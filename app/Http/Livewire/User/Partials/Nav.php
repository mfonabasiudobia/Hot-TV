<?php

namespace App\Http\Livewire\User\Partials;

use Livewire\Component;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;

class Nav extends Component
{

    public $currentNav = 'favourites';
    public $subscriptionPlan;

    public function mount(){
        if(request()->has('p')){
            $this->currentNav = request('p');
        }

        $order = SubscriptionOrder::where('user_id', auth()->user()->id)
        ->where('status', 'paid')
        ->first();
        
        if($order) {
            $this->subscriptionPlan = $order->subscription->name;
        }
    }

    public function setNav($value){
        $this->currentNav = $value;

        $this->emit('setNav', $value);

        $this->dispatchBrowserEvent('change-nav', ['page' => $value]);
    }

    public function render()
    {
        return view('livewire.user.partials.nav');
    }
}
