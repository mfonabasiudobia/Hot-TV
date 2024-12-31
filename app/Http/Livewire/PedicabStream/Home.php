<?php

namespace App\Http\Livewire\PedicabStream;

use App\Models\Ride;
use Livewire\Component;

class Home extends Component
{
    public $streams;

    public function mount()
    {
        $this->streams = collect(Ride::paginate(10));
    }

    public function render()
    {
        return view('livewire.pedicab-stream.home');
    }
}
