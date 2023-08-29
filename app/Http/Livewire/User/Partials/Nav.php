<?php

namespace App\Http\Livewire\User\Partials;

use Livewire\Component;

class Nav extends Component
{

    public $currentNav = 'favourites';

    public function setNav($value){
        $this->currentNav = $value;

        $this->emit('setNav', $value);
    }

    public function render()
    {
        return view('livewire.user.partials.nav');
    }
}
