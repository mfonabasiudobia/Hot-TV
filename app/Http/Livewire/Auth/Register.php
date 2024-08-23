<?php

namespace App\Http\Livewire\Auth;

use App\Enums\User\StatusEnum;
use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class Register extends BaseComponent
{

    public $username, $first_name, $last_name, $email, $password, $password_confirmation;
    public $show = 'register_form';
    public $selectedPlan;
    public $plans;
    public $subscription;
    public $paymentMethod;


    public function mount($planId = null)
    {

        if($planId) {

            $this->subscription = Subscription::whereId($planId)->first();
        }

        $this->plans = SubscriptionPlan::whereStatus('published')->get();
        $this->paymentMethod = 'paypal';
    }
    public function submit(){

        $stripePlanId = $this->subscription->stripe_plan_id;

        Stripe::setApiKey(gs()->payment_stripe_secret);

        // try {

        $customer = Customer::create([
            'email' => $this->email,
            'name' => "$this->first_name $this->last_name"

        ]);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $stripePlanId,
                    'quantity' => 1,
                ],
            ],
            'customer' => $customer->id,
            'mode' => 'subscription',
            'success_url' => config('app.redirect_success_url'), //http://localhost/payment-verification?session_id={CHECKOUT_SESSION_ID}',//route('payment-verification', ['order' => $order->id]),
            //'cancel_url' => 'http://localhost/cancel',//route('checkout'),
        ]);



        $user = AuthRepository::register([
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'status' => StatusEnum::LOCKED->value
        ]);

        $order = [
            'amount' => $session->amount_subtotal/100,
            'subscription_id' => $this->subscription->id,
            'user_id' => $user->id,
            'payment_method_type' => 'stripe',
            'session_id' => $session->id,
            'sub_total' => $session->amount_subtotal/100,
        ];
        $order = SubscriptionOrder::create($order);

        return redirect($session->url);
        // } catch (\Throwable $e) {
        //     return toast()->danger($e->getMessage())->push();
        // }
    }

    public function next(): void
    {
        $validated = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6|alpha_num'
        ]);
        if($validated) {

            if(!$this->subscription) {
                $this->show = 'plans';
            } else {
                $this->show = 'checkout';
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
}
