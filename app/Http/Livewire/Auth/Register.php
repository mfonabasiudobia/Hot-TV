<?php

namespace App\Http\Livewire\Auth;

use App\Enums\User\StatusEnum;
use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;

class Register extends BaseComponent
{

    public $username, $first_name, $last_name, $email, $password, $password_confirmation;
    public $show = 'register_form';
    public $selectedPlan;
    public $plans;
    public $subscription;
    public $paymentMethod;
    public $allowRegistration;


    public function mount($planId = null)
    {

        if(gs()->payment_stripe_status == 1 || gs()->payment_paypal_status == 1) {
            $this->allowRegistration = true;
        } else {
            $this->allowRegistration = false;
        }

        if($planId) {

            $this->subscription = Subscription::whereId($planId)->first();
        }

        $this->plans = SubscriptionPlan::whereStatus('published')->get();
        $this->paymentMethod = 'stripe';


    }
    public function submit(){
        if($this->paymentMethod == 'stripe') {
            Stripe::setApiKey(gs()->payment_stripe_secret);

            $stripePlanId = $this->subscription->stripe_plan_id;

            try {
                $price = Price::retrieve($stripePlanId);
                if(!$price) {
                    dd('chcking it');
                }
            } catch (InvalidRequestException $e) {
                $product = $this->getOrCreateProduct($this->subscription->name);
                dd($product);
                $price = $this->createPrice($product->id, $this->subscription->price, 'usd');

                $this->subscription->stripe_plan_id = $price->id;
                $this->subscription->save();
            }

            $customer = Customer::create([
                'email' => $this->email,
                'name' => "$this->first_name $this->last_name"
            ]);

            $user = AuthRepository::register([
                'username' => $this->username,
                'email' => $this->email,
                'password' => $this->password,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'status' => StatusEnum::LOCKED->value,
                'stripe_customer_id' => $customer->id,
            ]);

            if($this->subscription->plan->trail) {
                $stripSessionObject['subscription_data'] =['trial_period_days' => $this->subscription->plan->trail_period];
                $subscriptionStatus = OrderStatusEnum::TRAIL->value;
            } else {
                $subscriptionStatus = OrderStatusEnum::PENDING->value;
            }

            $stripSessionObject['payment_method_types'] = ['card'];
            $stripSessionObject['line_items'] = [['price' => $stripePlanId,'quantity' => 1,],];
            $stripSessionObject['customer'] = $customer->id;
            $stripSessionObject['mode'] = 'subscription';
            $stripSessionObject['success_url'] = url('plan/stripe/payment-verification/{CHECKOUT_SESSION_ID}'); //config('app.redirect_success_url'), //http://localhost/payment-verification?session_id={CHECKOUT_SESSION_ID}',//route('payment-verification', ['order' => $order->id]),
            //$stripSessionObject['cancel_url'] = 'http://localhost/cancel',//route('checkout');

            $session = Session::create([
                $stripSessionObject
            ]);

            $order = [
                'amount' => $session->amount_subtotal/100,
                'subscription_id' => $this->subscription->id,
                'user_id' => $user->id,
                'payment_method_type' => 'stripe',
                'session_id' => $session->id,
                'sub_total' => $session->amount_subtotal/100,
                'status' => $subscriptionStatus
            ];
            $order = SubscriptionOrder::create($order);

            return redirect($session->url);
        } else {
            $provider = new PayPalClient([]);
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            try {
                $paypalPlan = $this->getPayPalPlan($this->subscription->paypal_plan_id);
            } catch (Exception $e) {
                $product = $this->getOrCreatePayPalProduct($this->subscription->name);
                $paypalPlan = $this->createPayPalPlan($product['id'], $this->subscription->price);
            
                // Update subscription with new PayPal plan ID
                $this->subscription->paypal_plan_id = $paypalPlan['id'];
                $this->subscription->save();
            }

            $user = AuthRepository::register([
                'username' => $this->username,
                'email' => $this->email,
                'password' => $this->password,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'status' => StatusEnum::LOCKED->value,
                //'stripe_customer_id' => $customer->id,
            ]);


            if($this->subscription->plan->trail) {
                $paypalPlanId = $this->subscription->paypal_plan_id[str_replace(' ', '_', $this->subscription->plan->trail_period_paypal)];
                $subscriptionStatus = OrderStatusEnum::TRAIL->value;
            } else {
                // $paypalPlanId = $this->subscription->paypal_plan_id['without_trail'];
                $paypalPlanId = $this->subscription->paypal_plan_id;
                $subscriptionStatus = OrderStatusEnum::PENDING->value;
            }

            $subscription = $provider->createSubscription([
                'plan_id' => $paypalPlanId,
                'subscriber' => [
                    'name' => [
                        'given_name' => $this->first_name,
                        'surname' => $this->last_name,
                    ],
                    'email_address' => $this->email,
                ],
                'application_context' => [
                    'brand_name' => 'Hot TV',
                    'locale' => 'en-US',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'payment_method' => [
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                    ],
                    'return_url' => route('plan.paypal.payment-verification.success'),
                    'cancel_url' => route('plan.paypal.payment-cancel'),
                ],
            ]);


            $order = [
                'amount' => $this->subscription->price,
                'subscription_id' => $this->subscription->id,
                'user_id' => $user->id,
                'payment_method_type' => 'paypal',
                'session_id' => $subscription['id'],
                'sub_total' => $this->subscription->price,
                'status' => $subscriptionStatus

            ];
            $order = SubscriptionOrder::create($order);

            $approvalUrl = $subscription['links'][0]['href'];
            return redirect($approvalUrl);
        }

        // } catch (\Throwable $e) {
        //     return toast()->danger($e->getMessage())->push();
        // }
    }

    public function next(): void
    {
        if(auth()->check()) {
            $this->show = 'checkout';
        } else {
            $validated = $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:users,username|alpha_num',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6'
            ]);

            if($validated) {

                if(!$this->subscription) {
                    $this->show = 'plans';
                } else {
                    $this->show = 'checkout';
                }
            }
        }
    }



    public function selectPlan($planId): void
    {

        $this->subscription = Subscription::whereId($planId)->first();
        $this->show = 'checkout';
    }

    public function back(): void
    {
        $this->show = 'register_form';
    }


    public function render()
    {
        return view('livewire.auth.register');
    }

    private function getOrCreateProduct($name)
    {
        $products = Product::all();
        foreach ($products->data as $existingProduct) {
            if ($existingProduct->name === $name) {
                return $existingProduct;
            }
        }

        return Product::create([
            'name' => $name,
            'active' => true,
        ]);
    }
    
    private function getPayPalPlan(string $paypalPlanId): array
    {
        $provider = $this->getPayPalProvider();
        return $provider->showPlanDetails($paypalPlanId);
    }

    private function getPayPalProvider()
    {
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        return $provider;
    }

    private function getOrCreateProductPaypal($name)
    {
        $provider = $this->getPayPalProvider();

        $products = $provider->getProducts();

        foreach ($products->items as $existingProduct) {
            if ($existingProduct->name === $name) {
                return $existingProduct;
            }
        }
        $paypalProduct = $provider->createProduct([
            'name' => $request->input('name'),
            'description' => $request->input('name'),
            'type' => 'SERVICE',
            'category' =>   'SOFTWARE'
        ]);

        $paypalProductId = $paypalProduct['id'];

        return $paypalProduct;
    }

    private function getOrCreatePaypalPlan($name, $amount, $paypalProductId)
    {
        $paypalPlan = $provider->createPlan([
            'product_id' => $paypalProductId,
            'name' => $name,
            'description' => $name,
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => $request->input('subscription_plan_id') == 1 ? 'MONTH' : 'YEAR',
                        'interval_count' => 1,
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => $amount,
                            'currency_code' => 'USD'
                        ],
                    ],
                ],
            ],
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee' => [
                    'value' => 0,
                    'currency_code' => 'USD'
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 3
            ],
        ]);

        return $paypalPlan;
    }

    private function createPrice($productId, $amount, $currency)
    {
        $interval = $request->input('subscription_plan_id') == 1 ? 'MONTH' : 'YEAR';

        return Price::create([
            'unit_amount' => $amount,
            'currency' => $currency,
            'recurring' => [
                'interval' => $interval,
            ],
            'product' => $productId,
        ]);
    }
}
