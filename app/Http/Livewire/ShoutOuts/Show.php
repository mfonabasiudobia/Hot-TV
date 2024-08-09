<?php

namespace App\Http\Livewire\ShoutOuts;

use App\Models\PodcastView;
use App\Models\Shoutout;
use App\Models\ShoutoutView;
use App\Repositories\ShoutoutRepository;
use Livewire\Component;

class Show extends Component
{
    public $shoutout;

    public function mount($slug)
    {

        $this->fill([
            'shoutout' => ShoutoutRepository::getBySlug($slug)
        ]);

        $data = [
            'user_id' => auth()->id() ?? null,
            'shoutout_id' => $this->shoutout->id,
            'ip_address' => request()->ip()
        ];

        ShoutoutView::firstOrCreate($data, $data);

    }

    public function render()
    {
        return view('livewire.shoutout.show');
    }

}
