<?php

namespace App\Http\Livewire\User\Profile\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Nav extends Component
{

     public $currentNav = 'profile';
     public $avatarUrl;

     public function mount()
     {
         $user = Auth::user();
         $this->avatar = $user->avatarUrl;
     }

    public function setNav($value){

        $this->currentNav = $value;

        $this->emit('setNav', $value);


     }

    public function render()
    {
        return view('livewire.user.profile.partials.nav');
    }
}
