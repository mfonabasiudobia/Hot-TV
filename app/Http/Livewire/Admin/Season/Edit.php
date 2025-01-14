<?php

namespace App\Http\Livewire\Admin\Season;

use App\Http\Livewire\BaseComponent;
use App\Repositories\SeasonRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\EpisodeRepository;
use Illuminate\Support\Str;
use App\Enums\VideoDiskEnum;
use App\Jobs\ConvertVideoForDownloadingJob;
use App\Jobs\ConvertVideoForStreamingJob;

class Edit extends BaseComponent
{

     public $title, $slug, $description, $release_date, $thumbnail;

     public $recorded_video, $tvshow, $season, $tv_show_id;

     public $season_number, $episode_number, $duration, $status;

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
            'tv_show_id' => $this->season->tv_show_id,
            'status' => $this->season->status == 'published'
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
                'season_number' => $this->season_number,
                'tv_show_id' => $this->tv_show_id,
                'status' => $this->status ? 'published' : 'unpublished'
            ];

            throw_unless(SeasonRepository::updateSeason($data, $this->season->id), "Please try again");

            if($this->recorded_video){
                $uuid = Str::uuid();
                $filename = $uuid . '.' . $this->recorded_video->getClientOriginalExtension();

                if($this->season->video) {
                    $this->season->video->update([
                        'uuid' => $uuid,
                        'title' => $this->title,
                        'disk' => VideoDiskEnum::DISK->value,
                        'original_name' => $this->recorded_video->getClientOriginalName(),
                        'path' => $this->recorded_video->storeAs(VideoDiskEnum::TV_SHOWS->value . $this->season->tvShow->slug . '/' . $this->season->slug, $filename, VideoDiskEnum::DISK->value),
                    ]);
                }else{
                    $video = $this->season->video()->create([
                        'uuid' => $uuid,
                        'title' => $this->title,
                        'disk' => VideoDiskEnum::DISK->value,
                        'original_name' =>  $this->recorded_video->getClientOriginalName(),
                        'path' => $this->recorded_video->storeAs(VideoDiskEnum::TV_SHOWS->value . $this->season->tvShow->slug . '/' . $this->season->slug, $filename, VideoDiskEnum::DISK->value),
                    ]);
                }

                dispatch(new ConvertVideoForDownloadingJob(VideoDiskEnum::TV_SHOWS->value . $this->season->tvShow->slug, $this->season->video, $this->season->slug));
                dispatch(new ConvertVideoForStreamingJob(VideoDiskEnum::TV_SHOWS->value . $this->season->tvShow->slug, $this->season->video, $this->season->slug));
            }

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
