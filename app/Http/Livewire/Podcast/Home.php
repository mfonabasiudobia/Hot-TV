<?php

namespace App\Http\Livewire\Podcast;

use App\Models\Podcast;
use App\Models\Shoutout;
use Livewire\Component;

class Home extends Component
{
    public $perPage = 10;

    public function loadMore()
    {
        $this->perPage += 10;
        $this->render();
    }

    public function render()
    {

        $podcasts = Podcast::where('status', 'published')

            ->orderBy('created_at', 'desc')->paginate($this->perPage);



        return view('livewire.podcast.home')->with('podcasts',  $podcasts);
    }
}
