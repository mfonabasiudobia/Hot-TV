<?php

namespace App\Http\Livewire\Admin\RideDuration;

use App\Http\Livewire\BaseComponent;
use App\Repositories\RideDurationRepository;
use App\Repositories\ShowCategoryRepository;

class Create extends BaseComponent
{
        public $duration, $price, $stream;

        public function updatedName(){
            $this->slug = str()->slug($this->duration);
        }

        public function submit(){

            $this->validate([
                'duration' => 'required',
                'price' => 'required',
                'stream' => 'required'
            ]);


            $data = [
                'duration' => $this->duration,
                'price' => $this->price,
                'stream' => $this->stream
            ];

            try {

                throw_unless(RideDurationRepository::createDuration($data), 'An error occured, please try again');

                toast()->success('Duration has been created')->push();

                redirect()->route('admin.ride.durations');

            } catch (\Throwable $e) {
                toast()->danger($e->getMessage())->push();
            }
    }


    public function render()
    {
        return view('livewire.admin.ride-duration.home.create')->layout('layouts.admin-base');
    }
}
