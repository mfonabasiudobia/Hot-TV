<?php

namespace App\Http\Livewire\Admin\Episode;

use App\Http\Livewire\BaseComponent;
use App\Repositories\SeasonRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;
use Illuminate\Support\Str;
use App\Enums\VideoDiskEnum;
use App\Jobs\ConvertVideoForDownloadingJob;
use App\Jobs\ConvertVideoForStreamingJob;
use App\Jobs\CalculateDuration;

class Edit extends BaseComponent
{

     public $title, $slug, $description, $release_date, $thumbnail;

     public $season_id, $recorded_video, $tvshow, $episode, $tv_show_id;

     public $season_number, $episode_number, $duration, $status, $selectedEpisodes = [];

    public $seasons = [];

    public function mount($id){
        // $this->tvshow = TvShowRepository::getTvShowBySlug($tvslug);
        $this->episode = EpisodeRepository::getEpisodeById($id);
        $this->seasons = SeasonRepository::getSeasonsBytvShowId($this->episode->tv_show_id);
        $this->fill([
            'title' => $this->episode->title,
            'description' => $this->episode->description,
            'slug' => $this->episode->slug,
            // 'recorded_video' => $this->episode->recorded_video,
            'thumbnail' => $this->episode->thumbnail,
            'release_date' => $this->episode->release_date,
            'season_id' => $this->episode->season_id,
            'episode_number' => $this->episode->episode_number,
            'duration' => $this->episode->duration,
            'tv_show_id' => $this->episode->tv_show_id,
            'status' => $this->episode->status == 'published'
        ]);

        $this->UpdateStartRange();
    }

    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }

    public function UpdateSeasons()
    {
        $this->seasons = SeasonRepository::getSeasonsBytvShowId($this->tv_show_id);
    }

    public function UpdateStartRange()
     {
        $this->selectedEpisodes =  EpisodeRepository::getEpisodesBySeason($this->tv_show_id, $this->season_id)->pluck('episode_number')->toArray();
     }

    public function submit(){
        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:tv_shows,slug,',
            'description' => 'required',
            'season_id' => 'required',
            'duration' => 'required|numeric|min:0',
            'release_date' => 'required|date',
            'thumbnail' => 'required',
            // 'recorded_video' => 'required',
            'tv_show_id' => 'required|exists:tv_shows,id',
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
                'season_id' => $this->season_id,
                'episode_number' => $this->episode_number,
                'duration' => $this->duration,
                'tv_show_id' => $this->tv_show_id,
                'status' => $this->status ? 'published' : 'unpublished'
            ];

            throw_unless(EpisodeRepository::updateEpisode($data, $this->episode->id), "Please try again");

            if($this->recorded_video){
                $uuid = Str::uuid();
                $filename = $uuid . '.' . $this->recorded_video->getClientOriginalExtension();

                $this->episode->video->update([
                    'uuid' => $uuid,
                    'title' => $this->title,
                    'disk' => VideoDiskEnum::DISK->value,
                    'original_name' =>  $this->recorded_video->getClientOriginalName(),
                    'path' => $this->recorded_video->storeAs(VideoDiskEnum::TV_SHOWS->value . $this->episode->tvShow->slug . '/'. $this->episode->season->slug . '/' . $this->episode->slug, $filename, VideoDiskEnum::DISK->value),
                ]);

                dispatch(new CalculateDuration($this->episode->video, $this->episode));
                dispatch(new ConvertVideoForDownloadingJob(VideoDiskEnum::TV_SHOWS->value . $this->episode->tvShow->slug . '/'. $this->episode->season->slug, $this->episode->video, $this->episode->slug));
                dispatch(new ConvertVideoForStreamingJob(VideoDiskEnum::TV_SHOWS->value . $this->episode->tvShow->slug . '/'. $this->episode->season->slug, $this->episode->video, $this->episode->slug));
            }

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
