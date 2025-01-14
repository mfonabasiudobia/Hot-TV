<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Enums\VideoDiskEnum;
use App\Http\Livewire\BaseComponent;
use App\Jobs\ConvertVideoForDownloadingJob;
use App\Jobs\ConvertVideoForStreamingJob;
use App\Repositories\SeasonRepository;
use App\Repositories\TvShowRepository;
use App\Repositories\CastRepository;
use App\Repositories\ShowCategoryRepository;
use Illuminate\Support\Str;

class Create extends BaseComponent
{

    public $title, $slug, $description, $release_date, $end_time, $schedule_date, $thumbnail;

    public $categories = [], $categories_id = [], $trailer, $casts_id = [], $casts = [];

    public $tags = [], $meta_title, $meta_description, $is_recommended = 0, $status = 'unpublished';

    public function mount(){
        $this->fill([
            'categories' => ShowCategoryRepository::all(),
            'casts' => CastRepository::all()
        ]);
    }

    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }


    public function submit(){
        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:tv_shows,slug',
            'description' => 'required',
            'release_date' => 'required|date',
            'thumbnail' => 'required',
            'categories_id' => 'required|array',
            'casts_id' => 'required|array',
            'trailer' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'tags' => 'array',
        ],[
            'release_date.*' => 'Invalid Release Date Selected',
            'categories_id' => 'Select at least 1 category to continue',
            'casts_id' => 'Select at least 1 cast to continue'
        ]);

        try {

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'tags' => $this->tags,
                'description' => $this->description,
                'release_date' => $this->release_date,
                'thumbnail' => $this->thumbnail,
                'trailer' => $this->trailer,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'is_recommended' => $this->is_recommended,
                'status' => $this->status ? 'published' : 'unpublished'
            ];

            $tvShow = throw_unless(TvShowRepository::createTvShow($data, [
                'categories' => $this->categories_id,
                'casts' => $this->casts_id,
            ]), "Please try again");

            $season = SeasonRepository::createSeason([
                'title' => 'Season 1',
                'slug' => 'season-1',
                'description' => $this->description,
                'release_date' => $this->release_date,
                'tv_show_id' => $tvShow->id,
                'season_number' => 'Season 1',
                'status'    => 'published'
            ]);

            $uuid = Str::uuid();
            $filename = $uuid . '.' . $this->trailer->getClientOriginalExtension();

            $video = $tvShow->video()->create([
                'uuid' => $uuid,
                'title' => $this->title,
                'disk' => VideoDiskEnum::DISK->value,
                'original_name' =>  $this->trailer->getClientOriginalName(),
                'path' => $this->trailer->storeAs(VideoDiskEnum::TV_SHOWS->value . $tvShow->slug , $filename, VideoDiskEnum::DISK->value),
            ]);

            dispatch(new ConvertVideoForDownloadingJob(VideoDiskEnum::TV_SHOWS->value, $video, $tvShow->slug));
            dispatch(new ConvertVideoForStreamingJob(VideoDiskEnum::TV_SHOWS->value, $video, $tvShow->slug));

            toast()->success('Cheers!, Tv Show has been added')->pushOnNextPage();

            return redirect()->route('admin.tv-show.list');

        } catch (\Throwable $e) {
            dd($e->getMessage());
            //toast()->danger($e->getMessage())->push();

        }
    }

    public function render()
    {
        return view('livewire.admin.shows.create')->layout('layouts.admin-base');
    }
}
