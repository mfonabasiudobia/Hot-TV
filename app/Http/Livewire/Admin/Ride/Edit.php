<?php

namespace App\Http\Livewire\Admin\Ride;

use App\Http\Livewire\BaseComponent;
use App\Repositories\RideRepository;

class Edit extends BaseComponent
{
    public $ride, $driver, $customer, $status, $is_stream_blocked;

    public function mount($id){
        $this->ride = RideRepository::getById($id);

        $this->fill([
            'is_stream_blocked' => $this->ride->is_stream_blocked,
            'driver' => $this->ride->driver->username ?? 'Not Assigned',
            'customer' => $this->ride->customer->username ?? 'null',
            'status' => $this->ride->status,
        ]);
    }

    public function submit(){
        $this->validate([
            'is_stream_blocked' => 'required',
        ]);

        try {
            $data = [
                'is_stream_blocked' => $this->is_stream_blocked,
            ];

            throw_unless(RideRepository::update($data, $this->ride->id), "Please try again");

            toast()->success('Cheers!, Ride has been updated')->pushOnNextPage();

            return redirect()->route('admin.ride.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.ride.edit')->layout('layouts.admin-base');
    }
}
