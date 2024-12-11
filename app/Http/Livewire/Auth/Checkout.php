<?php

namespace App\Http\Livewire\Auth;

use App\Enums\User\StatusEnum;
use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class Checkout extends BaseComponent
{
    public $subscription, $plans;
    public function mount($planId)
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
        $this->paymentMethod = 'paypal';
    }

    public function submit(){

        $user = Auth::user();

        if($this->paymentMethod == 'stripe') {
            $stripePlanId = $this->subscription->stripe_plan_id;

            Stripe::setApiKey(gs()->payment_stripe_secret);



            $customer = Customer::create([
                'email' => $user->email,
                'name' => "$user->first_name $user->last_name"
            ]);

//            $user = AuthRepository::register([
//                'username' => $this->username,
//                'email' => $this->email,
//                'password' => $this->password,
//                'first_name' => $this->first_name,
//                'last_name' => $this->last_name,
//                'status' => StatusEnum::LOCKED->value,
//                'stripe_customer_id' => $customer->id,
//            ]);

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

//            $user = AuthRepository::register([
//                'username' => $this->username,
//                'email' => $this->email,
//                'password' => $this->password,
//                'first_name' => $this->first_name,
//                'last_name' => $this->last_name,
//                'status' => StatusEnum::LOCKED->value,
//                //'stripe_customer_id' => $customer->id,
//            ]);


            if($this->subscription->plan->trail) {

                $paypalPlanId = $this->subscription->paypal_plan_id[str_replace(' ', '_', $this->subscription->plan->trail_period_paypal)];
                $subscriptionStatus = OrderStatusEnum::TRAIL->value;
            } else {
                $paypalPlanId = $this->subscription->paypal_plan_id['without_trail'];
                $subscriptionStatus = OrderStatusEnum::PENDING->value;

            }
            $subscription = $provider->createSubscription([
                'plan_id' => $paypalPlanId,
                'subscriber' => [
                    'name' => [
                        'given_name' => $user->first_name,
                        'surname' => $user->last_name,
                    ],
                    'email_address' => $user->email,
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

    public function render()
    {
        return view('livewire.auth.checkout');
    }
}
