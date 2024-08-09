<?php

namespace App\Http\Livewire\ShoutOuts;

use App\Models\Shoutout;
use Livewire\Component;

class Home extends Component
{

    public $shoutouts;
    public function mount()
    {
        $this->shoutouts = Shoutout::where('status', 'published')->get();


    }
    public function render()
    {
        return view('livewire.shout-outs.home');
    }
}
