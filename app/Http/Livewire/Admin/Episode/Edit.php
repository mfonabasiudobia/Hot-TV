<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;

class Edit extends BaseComponent
{

     public $title, $slug, $description, $release_date, $thumbnail;

     public $recorded_video, $tvshow, $episode;

     public $season_number, $episode_number, $duration;

    public function mount($tvslug, $slug){
        $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
        $this->episode = EpisodeRepository::getEpisodeBySlug($slug, $this->tvshow->id);

        $this->fill([
            'title' => $this->episode->title,
            'description' => $this->episode->description,
            'slug' => $this->episode->slug,
            'recorded_video' => $this->episode->recorded_video,
            'thumbnail' => $this->episode->thumbnail,
            'release_date' => $this->episode->release_date,
            'season_number' => $this->episode->season_number,
            'episode_number' => $this->episode->episode_number,
            'duration' => $this->episode->duration,
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
            'episode_number' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'release_date' => 'required|date',
            'thumbnail' => 'required',
            'recorded_video' => 'required',
        ],[
            'release_date.*' => 'Invalid Release Date Selected'
        ]);

        try {

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'release_date' => $this->release_date,
                'thumbnail' => $this->thumbnail,
                'recorded_video' => $this->recorded_video,
                'tv_show_id' => $this->tvshow->id,
                'season_number' => $this->season_number,
                'episode_number' => $this->episode_number,
                'duration' => $this->duration
            ];

            throw_unless(EpisodeRepository::updateEpisode($data, $this->episode->id), "Please try again");

            toast()->success('Cheers!, Episode has been updated')->pushOnNextPage();

            return redirect()->route('admin.tv-show.show', ['slug' => $this->tvshow->slug ]);

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.admin.episode.edit')->layout('layouts.admin-base');
    }
}
