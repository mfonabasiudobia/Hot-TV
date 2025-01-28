<?php

namespace App\Http\Livewire\Admin\Ride;

use App\Repositories\DriverRepository;
use Livewire\Component;

class OnlineDrivers extends Component
{
    public $drivers;

    public function mount()
    {
        $this->drivers = DriverRepository::allOnlineDrivers();
    }

    public function render()
    {
        return view('livewire.admin.ride.online-drivers')->layout('layouts.admin-base');
    }
}
