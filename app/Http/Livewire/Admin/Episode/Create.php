<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Http\Livewire\BaseComponent;

class Create extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.episode.create')->layout('layouts.admin-base');
    }
}
