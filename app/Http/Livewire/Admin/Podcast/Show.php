<?php

namespace App\Http\Livewire\Admin\Podcast;

use App\Http\Livewire\BaseComponent;

class Show extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.podcast.show')->layout('layouts.admin-base');
    }
}
