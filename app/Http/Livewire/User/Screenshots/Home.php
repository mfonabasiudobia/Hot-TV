<?php

namespace App\Http\Livewire\User\Screenshots;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TravelRepository;

class Home extends BaseComponent
{

    public function render()
    {
        return view('livewire.user.screenshots.home', ['customPhotos' => TravelRepository::getCustomTravelPhotos(auth()->id())->get()]);
    }
}
