<?php

namespace App\Http\Livewire\User\Partials;

use Livewire\Component;

class Nav extends Component
{

    public $currentNav = 'favourites';

    public function mount(){
        if(request()->has('p')){
            $this->currentNav = request('p');
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
