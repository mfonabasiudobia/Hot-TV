<?php

namespace App\Http\Livewire\Admin\Podcast;

use App\Http\Livewire\BaseComponent;

class Home extends BaseComponent
{
    public function render()
    {
        return view('livewire.admin.podcast.home')->layout('layouts.admin-base');
    }
}
