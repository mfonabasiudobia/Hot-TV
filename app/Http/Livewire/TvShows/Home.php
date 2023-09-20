<?php

namespace App\Http\Livewire\TvShows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;

class Home extends BaseComponent
{

    public $sortByTitle, $sortByTime = "month", $page = 1, $sortByDate = "desc";

    public function sortByTitle(){
        $this->sortByDate = null;
        $this->sortByTitle = $this->sortByTitle === "desc" ? "asc" : "desc";
    }

    public function sortByTime($value){
        $this->sortByTime = $value;
    }

    public function sortByDate(){
        $this->sortByTitle = null;
        $this->sortByDate = $this->sortByDate == "desc" ? "asc" : "desc";
    }


    public function render()
    {
        return view('livewire.tv-shows.home', ['tvShows' => TvShowRepository::all([
            'sortByTitle' => $this->sortByTitle,
            'sortByTime' => $this->sortByTime,
            'sortByDate' => $this->sortByDate
        ])->paginate(12)]);
    }
}
