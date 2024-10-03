<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Http\Livewire\BaseComponent;
use App\Jobs\ConvertVideoForDownloadingJob;
use App\Jobs\ConvertVideoForStreamingJob;
use App\Models\Video;
use App\Repositories\SeasonRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;

class Create extends BaseComponent
{

     public $title, $slug, $description, $release_date, $end_time, $schedule_date, $thumbnail;

     public $recorded_video, $tvshow;

     public $season_id, $episode_number, $duration, $tv_show_id;

     public $seasons = [];

     public function mount(){
        // $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
     }

     public function updatedTitle($title){
        $this->slug = str()->slug($title);
     }

     public function UpdateSeasons()
     {
         $this->seasons = SeasonRepository::getSeasonsBytvShowId($this->tv_show_id);
     }

     public function submit(){

        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:tv_shows,slug',
            'description' => 'required',
            'season_id' => 'required',
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
                'tv_show_id' => $this->tv_show_id,
                'season_id' => $this->season_id,
                'episode_number' => $this->episode_number,
                'duration' => $this->duration
            ];

            $episode = throw_unless(EpisodeRepository::createEpisode($data), "Please try again");
            $video = $episode->video()->create([
                'title' => $this->title,
                'disk' => 'public',
                'original_name' =>  $this->recorded_video->getClientOriginalName(),
                'path' => $this->recorded_video->store('videos', 'public'),
            ]);

            dispatch(new ConvertVideoForDownloadingJob($video));
            dispatch(new ConvertVideoForStreamingJob($video));

            toast()->success('Cheers!, Tv Show has been added')->pushOnNextPage();

            return redirect()->route('admin.tv-show.episode.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
     }


    public function render()
    {
        return view('livewire.admin.episode.create')->layout('layouts.admin-base');
    }
}
