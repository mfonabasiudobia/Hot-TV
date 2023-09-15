<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Http\Livewire\BaseComponent;

class Show extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.shows.show')->layout('layouts.admin-base');
    }
}
