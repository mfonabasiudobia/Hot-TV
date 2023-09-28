<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class Header extends Component
{

    protected $listeners = ['refreshCart' => '$refresh'];
    
    public function render()
    {
        return view('livewire.partials.header');
    }
}
