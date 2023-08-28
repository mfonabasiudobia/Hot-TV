<?php

namespace App\Http\Livewire\User\Dashboard;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.user.dashboard.home')->layout('layouts.user-base');
    }
}
