<?php

namespace App\Http\Livewire\Podcast;

use App\Http\Livewire\BaseComponent;
use App\Models\PodcastView;
use App\Repositories\PodcastRepository;

class Show extends BaseComponent
{

    public $podcast;

    public function mount($slug){

        $this->fill([
            'podcast' => PodcastRepository::getPodcastBySlug($slug)
        ]);

        if(isset($result['id'])){
           $data = [
                'user_id' => auth()->id(),
                'stream_id' => $this->podcast->id,
                'ip_address' => request()->ip()
            ];

            PodcastView::firstOrCreate($data, $data);
        }

    }


    public function render()
    {
        return view('livewire.podcast.show');
    }
}
