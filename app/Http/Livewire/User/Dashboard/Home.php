<?php

namespace App\Http\Livewire\User\Dashboard;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{

    protected $listeners = ['setNav'];

    public $currentNav = 'wishlist';

    public function mount(){
        if(request()->has('p')){
            $this->currentNav = request('p');
        }
    }

    public function setNav($value){
        $this->currentNav = $value;
    }


    public function render()
    {
        return view('livewire.user.dashboard.home')->layout('layouts.user-base');
    }
}
