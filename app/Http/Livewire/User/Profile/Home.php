<?php

namespace App\Http\Livewire\User\Profile;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    

    protected $listeners = ['setNav'];

    public $currentNav = 'profile';
    

    public function setNav($value){
        $this->currentNav = $value;
    }
    
    public function render()
    {
        return view('livewire.user.profile.home')->layout('layouts.user-base');
    }
}
