<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Http\Livewire\BaseComponent;
use App\Models\Stream;

class Home extends BaseComponent
{   

    public $currentTab = 'upcoming';

    public function setTab($value){
        $this->currentTab = $value;
    }


    public function render()
    {
        $streams = Stream::query()
        ->orderBy('schedule_date', 'desc')
        ->when($this->currentTab == 'upcoming', function($q){
            $q->whereDate('schedule_date', '>=', now()->today());
        })
        ->when($this->currentTab == 'past', function($q){
            $q->whereDate('schedule_date', '<', now()->today());
        })
        ->orderBy('start_time')
        ->get()
        ->groupBy(function ($stream) {
            return $stream->schedule_date;
        });

        return view('livewire.admin.dashboard.home', compact('streams'))->layout('layouts.admin-base');
    }
}
