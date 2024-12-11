<?php

namespace App\Http\Livewire\User\Profile;

use App\Http\Livewire\BaseComponent;


class Profile extends BaseComponent
{
    

    

    public function render()
    {
        return view('livewire.user.profile.profile')->layout('layouts.user-base');
    }
}