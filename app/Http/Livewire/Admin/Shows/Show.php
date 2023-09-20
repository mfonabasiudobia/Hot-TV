<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;

class Show extends BaseComponent
{
    public $tvshow;

    public function mount($slug){
        $this->tvshow = TvShowRepository::getTvShowBySlug($slug);
    }

    public function render()
    {
        return view('livewire.admin.shows.show')->layout('layouts.admin-base');
    }
}
