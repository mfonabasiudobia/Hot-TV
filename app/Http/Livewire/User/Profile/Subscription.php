<?php

namespace App\Http\Livewire\User\Profile;

use App\Http\Livewire\BaseComponent;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;


class Subscription extends BaseComponent
{
    public $order = null;

    public function mount()
    {
        $order = SubscriptionOrder::where('user_id', auth()->user()->id)
        ->where('status', 'paid')
        ->first();
        
        if($order) {
            $this->order = $order;
        }
        
    }

    public function render()
    {
        return view('livewire.user.profile.subscription')->layout('layouts.user-base');
    }
}