<?php

namespace App\Http\Livewire\Admin\RideDuration;

use App\Http\Livewire\BaseComponent;
use App\Repositories\RideDurationRepository;
use App\Repositories\ShowCategoryRepository;

class Edit extends BaseComponent
{

    public $rideDuration, $duration, $price, $stream;


    public function mount($id){
        $this->rideDuration = RideDurationRepository::getDurationById($id);

        $this->fill([
            'duration' => $this->rideDuration->duration,
            'price' => $this->rideDuration->price,
            'stream' => $this->rideDuration->stream,
        ]);

    }

    public function updatedName(){
        $this->slug = str()->slug($this->name);
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

            throw_unless(RideDurationRepository::updateDuration($data, $this->rideDuration->id), 'An error occured, please try again');

            toast()->success('Duration has been updated')->push();

            redirect()->route('admin.ride.durations');

        } catch (\Throwable $e) {

            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.ride-duration.edit')->layout('layouts.admin-base');
    }
}
