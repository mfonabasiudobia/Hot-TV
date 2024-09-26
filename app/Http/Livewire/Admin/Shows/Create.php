<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\CastRepository;
use App\Repositories\ShowCategoryRepository;

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

            throw_unless(TvShowRepository::createTvShow($data, [
                'categories' => $this->categories_id,
                'casts' => $this->casts_id,
            ]), "Please try again");

            toast()->success('Cheers!, Tv Show has been added')->pushOnNextPage();

            return redirect()->route('admin.tv-show.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.shows.create')->layout('layouts.admin-base');
    }
}
