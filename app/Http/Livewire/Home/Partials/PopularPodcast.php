<?php

namespace App\Http\Livewire\Home\Partials;

use App\Models\Podcast;
use Livewire\Component;

class PopularPodcast extends Component
{
    public function render()
    {

        $podcastFirst = Podcast::where('status', 'published')
            ->orderBy('created_at', 'desc')->first();

        $podcasts = Podcast::where('status', 'published')
            ->orderBy('created_at', 'desc')->skip(1)->take(4);


        return view('livewire.home.partials.popular-podcast')->with(['podcastFirst', $podcastFirst, 'podcasts', $podcasts]);
    }
}
