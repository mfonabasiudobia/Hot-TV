<?php

namespace App\Http\Livewire\Admin\ShowCategory;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.show-category.home')->layout('layouts.admin-base');
    }
}
