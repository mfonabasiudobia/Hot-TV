<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.shows.home')->layout('layouts.admin-base');
    }
}
