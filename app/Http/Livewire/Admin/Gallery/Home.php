<?php

namespace App\Http\Livewire\Admin\Gallery;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.gallery.home')->layout('layouts.admin-base');
    }
}
