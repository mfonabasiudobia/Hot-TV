<?php

namespace App\Http\Livewire\LiveChannel;

use App\Http\Livewire\BaseComponent;
use App\Models\TvChannelView;
use App\Repositories\StreamRepository;

class Show extends BaseComponent
{
    public $timeArray = [], $infoArray = [];
    
    public function mount(){

        $result = StreamRepository::getCurrentStreamingInformation();

        if(isset($result['id'])){
           $data = [
                'user_id' => auth()->id(),
                'stream_id' => $result['id'],
                'ip_address' => request()->ip()
            ];

        TvChannelView::firstOrCreate($data, $data);
        }
    }

    public function render()
    {
        return view('livewire.live-channel.show');
    }
}