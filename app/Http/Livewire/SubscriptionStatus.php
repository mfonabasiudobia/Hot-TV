<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;

class SubscriptionStatus extends Component
{
    public $subscriptionPlan;

    public function mount()
    {
        $user = Auth::user();

        $order = SubscriptionOrder::where('user_id', $user->id)
            ->where('status', 'paid')
            ->first();

        if ($order) {
            $this->subscriptionPlan = $order->subscription->name;
        } else {
            $this->subscriptionPlan = 'Not subscribe';
        }
    }

    public function render()
    {
        return view('livewire.subscription-status');
    }
}
