<?php

namespace App\Http\Livewire\User\Partials;

use Botble\Media\Models\MediaFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;

class Nav extends Component
{

    public $currentNav = 'wishlist';
    public $avatar = null;
    public $user;
    public $subscriptionPlan;

    protected $listeners = ['reRender'];

    public function mount()
    {

        $this->user = Auth::user();
        if(request()->has('p')){
            $this->currentNav = request('p');
        }

        $order = SubscriptionOrder::where('user_id', $this->user->id)
        ->where('status', 'paid')
        ->first();

        if($order) {
            $this->subscriptionPlan = $order->subscription->name;
        } else {
            $this->subscriptionPlan = 'Not subscribe';
        }

        $this->avatar = $this->user->avatarUrl;
//        $media = MediaFile::query()->where('id', user()->avatar_id)->first();
//
//        if($media) {
//            $this->avatar = asset('storage/' . $media->url);
//        } else {
//            $this->avatar = asset('images/user-icon.jpg');
//        }
    }

    public function reRender()
    {
        $this->mount();
        $this->render();
    }

    public function setNav($value)
    {
        $this->currentNav = $value;

        $this->emit('setNav', $value);

        $this->dispatchBrowserEvent('change-nav', ['page' => $value]);
    }

    public function render()
    {
        return view('livewire.user.partials.nav');
    }
}
