<?php

namespace App\Http\Livewire\Admin\RideDuration;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.ride-duration.home')->layout('layouts.admin-base');
    }

}
