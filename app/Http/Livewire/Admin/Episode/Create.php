<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Enums\VideoDiskEnum;
use App\Http\Livewire\BaseComponent;
use App\Jobs\CalculateDuration;
use App\Jobs\ConvertVideoForDownloadingJob;
use App\Jobs\ConvertVideoForStreamingJob;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Str;

class Create extends BaseComponent
{

     public $title, $slug, $description, $release_date, $end_time, $schedule_date, $thumbnail;

     public $recorded_video, $tvshow, $status;

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
            // 'duration' => 'required|numeric|min:0',
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
                'status' => $this->status ? 'published' : 'unpublished'
            ];

            $episode = throw_unless(EpisodeRepository::createEpisode($data), "Please try again");
            $uuid = Str::uuid();
            $filename = $uuid . '.' . $this->recorded_video->getClientOriginalExtension();

            $video = $episode->video()->create([
                'uuid' => $uuid,
                'title' => $this->title,
                'disk' => VideoDiskEnum::DISK->value,
                'original_name' =>  $this->recorded_video->getClientOriginalName(),
                'path' => $this->recorded_video->storeAs(VideoDiskEnum::TV_SHOWS->value . $episode->tvShow->slug . '/'. $episode->season->slug . '/' . $episode->slug, $filename, VideoDiskEnum::DISK->value),
            ]);

            dispatch(new CalculateDuration($video, $episode));
            dispatch(new ConvertVideoForDownloadingJob(VideoDiskEnum::TV_SHOWS->value, $video, $episode->tvShow->slug . '/'. $episode->season->slug . '/' . $episode->slug));
            dispatch(new ConvertVideoForStreamingJob(VideoDiskEnum::TV_SHOWS->value, $video, $episode->tvShow->slug . '/'. $episode->season->slug . '/' . $episode->slug));

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
