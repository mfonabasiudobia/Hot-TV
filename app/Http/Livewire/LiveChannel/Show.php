<?php

namespace App\Http\Livewire\LiveChannel;

use App\Http\Livewire\BaseComponent;
use App\Models\Stream;

class Show extends BaseComponent
{
    public $timeArray = [], $infoArray = [];
    
    public function mount(){
        $records = Stream::whereDate('schedule_date', now())->get();    

         // Initialize an array to store the formatted data
        $this->timeArray = [];
        $this->infoArray = [];

        // Iterate through the data and format it as required
        foreach ($records as $item){

            $this->timeArray[] = [
                'start' => convert_time_to_streaming_time($item->start_time),
                'end' => convert_time_to_streaming_time($item->end_time)
            ];

            $this->infoArray[] = [
                'title' => $item->title,
                'description' => $item->description,
                'src' => file_path($item->recorded_video)
            ];
        }

    }

    public function render()
    {
        return view('livewire.live-channel.show');
    }
}