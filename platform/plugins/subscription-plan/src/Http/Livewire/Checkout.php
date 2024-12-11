<?php

namespace Botble\SubscriptionPlan\Http\Livewire;

use Botble\SubscriptionPlan\Http\Livewire\BaseComponent;
use Botble\SubscriptionPlan\Models\Subscription;
// use Stripe\Stripe;
// use Stripe\Checkout\Session;
// use Stripe\PaymentIntent;

class Checkout extends BaseComponent
{
    public $subscription;
    public $email;

    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function submit()
    {
        dd('this');
    }

    public function render()
    {
        return view('plugins/subscription-plan::livewire.checkout-detail');
    }
}
