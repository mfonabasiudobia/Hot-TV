<?php

namespace App\Http\Livewire\TvShows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;

class Home extends BaseComponent
{

    public $sortByTitle, $sortByTime = "month", $page = 1, $sortByDate = "desc";

    public $tvShow;

    public function mount(){
        $slug = Slug::where('key', "tv-shows")->firstorFail();

        $this->tvShow = Page::findOrFail($slug->reference_id);
    }

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
        ])->paginate(12)])->layout('layouts.app', [
            'seo_title' => $this->tvShow->meta->meta_value[0]['seo_title'] ?? $this->tvShow->name,
            'seo_description' => $this->tvShow->meta->meta_value[0]['seo_description'] ?? ''
        ]);
    }
}
