<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;

class Edit extends BaseComponent
{

     public $title, $slug, $description, $release_date, $thumbnail;

     public $recorded_video, $tvshow, $episode, $tv_show_id;

     public $season_number, $episode_number, $duration;

    public function mount($id){
        // $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
        $this->episode = EpisodeRepository::getEpisodeById($id);

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
            'tv_show_id' => $this->episode->tv_show_id
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
                'episode_number' => $this->episode_number,
                'duration' => $this->duration,
                'tv_show_id' => $this->tv_show_id
            ];

            throw_unless(EpisodeRepository::updateEpisode($data, $this->episode->id), "Please try again");

            toast()->success('Cheers!, Episode has been updated')->pushOnNextPage();

            return redirect()->route('admin.tv-show.episode.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.admin.episode.edit')->layout('layouts.admin-base');
    }
}
