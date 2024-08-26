<?php

namespace App\Http\Livewire\User\Screenshots;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TravelRepository;

class Home extends BaseComponent
{

    public function render()
    {
        $travelImages = TravelRepository::getCustomTravelPhotos(auth()->id())->get();

        return view('livewire.user.screenshots.home', ['customPhotos' => $travelImages]);
    }
}
