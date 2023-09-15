<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Http\Livewire\BaseComponent;

class Edit extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.episode.edit')->layout('layouts.admin-base');
    }
}
