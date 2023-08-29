<?php

namespace App\Http\Livewire\User\Profile;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.user.profile.home')->layout('layouts.user-base');
    }
}
