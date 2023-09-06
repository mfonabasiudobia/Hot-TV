<?php

namespace App\Http\Livewire\Admin\Calendar;

use Livewire\Component;
use App\Repositories\StreamRepository;

class Home extends Component
{

    public $stream = [];

    public function mount(){
        $this->stream = StreamRepository::getAllStreams();

        // dd($this->stream);
    }

    public function render()
    {
        return view('livewire.admin.calendar.home')->layout('layouts.admin-base');
    }
}
