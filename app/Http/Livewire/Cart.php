<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use Cart as CartLibrary;

class Cart extends BaseComponent
{

    public $carts = [];

    public function mount(){
        // CartLibrary::instance('product')->destroy();
        $this->fill([
            'carts' => CartLibrary::instance('product')->content()
        ]);
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
