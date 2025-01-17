<?php

namespace App\Http\Livewire\Admin\Ride;

use App\Http\Livewire\BaseComponent;
use App\Repositories\RideRepository;

class Show extends BaseComponent
{
    public $ride, $driver, $customer, $status, $is_stream_blocked;

    public function mount($id){
        $this->ride = RideRepository::getById($id);

        $this->fill([
            'is_stream_blocked' => $this->ride->is_stream_blocked,
            'driver' => $this->ride->driver ?? 'Not Assigned',
            'customer' => $this->ride->customer ?? 'null',
            'status' => $this->ride->status,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.ride.show')->layout('layouts.admin-base');
    }
}
