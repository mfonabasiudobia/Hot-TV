<?php

namespace App\Http\Livewire\Admin\Ride;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.ride.home')->layout('layouts.admin-base');
    }
}
