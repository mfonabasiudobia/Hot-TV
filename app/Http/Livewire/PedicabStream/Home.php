<?php

namespace App\Http\Livewire\PedicabStream;

use App\Models\Ride;
use Livewire\Component;

class Home extends Component
{
    private $liveStreams;
    public $liveStreamsData;
    private $endedStreams;
    public $endedStreamsData;

    public $activeTab = 'live-streams';

    public function mount()
    {
        $this->liveStreams = Ride::with('customer')->where('stream_status', 'streaming')->paginate(10);
        $this->endedStreams = Ride::with('customer')->where('stream_status', 'completed')->paginate(10);

        $this->liveStreamsData = collect($this->liveStreams->items());
        $this->endedStreamsData = collect($this->endedStreams->items());
    }

    public function selectTab($tab)
    {
        // dd($tab);
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.pedicab-stream.home', [
            'liveStreams' => $this->liveStreams,
            'endedStreams' => $this->endedStreams,
        ]);
    }
}
