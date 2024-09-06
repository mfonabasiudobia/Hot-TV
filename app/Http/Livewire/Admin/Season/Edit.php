<?php

namespace App\Http\Livewire\Admin\Season;

use App\Http\Livewire\BaseComponent;
use App\Repositories\SeasonRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;

class Edit extends BaseComponent
{

     public $title, $slug, $description, $release_date, $thumbnail;

     public $recorded_video, $tvshow, $season, $tv_show_id;

     public $season_number, $episode_number, $duration;

    public function mount($id){
        // $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
        $this->season = SeasonRepository::getSeasonById($id);

        $this->fill([
            'title' => $this->season->title,
            'description' => $this->season->description,
            'slug' => $this->season->slug,
            'recorded_video' => $this->season->recorded_video,
            'thumbnail' => $this->season->thumbnail,
            'release_date' => $this->season->release_date,
            'season_number' => $this->season->season_number,
            'tv_show_id' => $this->season->tv_show_id
        ]);
    }

    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }

    public function submit(){
        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:tv_shows,slug,',
            'description' => 'required',
            'season_number' => 'required|numeric|min:0',
            'release_date' => 'required|date',
            'thumbnail' => 'required',
            'recorded_video' => 'required',
            'tv_show_id' => 'required|exists:tv_shows,id'
        ],[
            'release_date.*' => 'Invalid Release Date Selected',
            'tv_show_id.*' => 'Select TV Show to proceed'
        ]);

        try {

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'release_date' => $this->release_date,
                'thumbnail' => $this->thumbnail,
                'recorded_video' => $this->recorded_video,
                'season_number' => $this->season_number,
                'tv_show_id' => $this->tv_show_id
            ];

            throw_unless(SeasonRepository::updateSeason($data, $this->season->id), "Please try again");

            toast()->success('Cheers!, Season has been updated')->pushOnNextPage();

            return redirect()->route('admin.tv-show.season.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.admin.season.edit')->layout('layouts.admin-base');
    }
}
