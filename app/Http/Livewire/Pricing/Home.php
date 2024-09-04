<?php

namespace App\Http\Livewire\Pricing;

use App\Enums\Ride\PaymentStatusEnum;
use App\Models\Plan;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{

    public $plans, $user;
    public function mount()
    {
        if(Auth::check()) {

            $this->user = Auth::user();
        }
        $this->plans = SubscriptionPlan::whereStatus('published')->get();

    }

    public function render()
    {
        return view('livewire.pricing.home');
    }
}
