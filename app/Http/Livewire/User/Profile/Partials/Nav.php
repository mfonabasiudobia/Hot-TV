<?php

namespace App\Http\Livewire\User\Profile\Partials;

use Livewire\Component;

class Nav extends Component
{

     public $currentNav = 'profile';

     public function setNav($value){
        $this->currentNav = $value;

        $this->emit('setNav', $value);
     }


    public function render()
    {
        return view('livewire.user.profile.partials.nav');
    }
}
