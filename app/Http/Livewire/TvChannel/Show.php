<?php

namespace App\Http\Livewire\TvChannel;

use App\Http\Livewire\BaseComponent;
use App\Models\TvChannelView;
use App\Repositories\StreamRepository;

class Show extends BaseComponent
{

    public $tvChannel;

    public function mount($slug){
        $this->fill([
            'tvChannel' => StreamRepository::getTvChannelBySlug($slug)
        ]);

        if(isset($result['id'])){
           $data = [
                'user_id' => auth()->id(),
                'stream_id' => $this->tvChannel->id,
                'ip_address' => request()->ip()
            ];

            TvChannelView::firstOrCreate($data, $data);
        }

    }

    public function render()
    {
        return view('livewire.tv-channel.show');
    }
}
