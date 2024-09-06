<?php

namespace App\Http\Livewire\Admin\Season;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{

    public function render()
    {

        return view('livewire.admin.season.home')->layout('layouts.admin-base');
    }
}
