<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\CastRepository;
use App\Repositories\ShowCategoryRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Edit extends BaseComponent
{

    public $title, $slug, $description, $release_date, $thumbnail;

    public $categories = [], $categories_id = [], $tvShow, $trailer, $casts_id = [], $casts = [];

    public $tags = [], $meta_title, $meta_description, $is_recommended, $status;


    public function mount($id){
        $this->tvShow = TvShowRepository::getTvShowById($id);

        $this->fill([
            'categories' => ShowCategoryRepository::all(),
            'casts' => CastRepository::all(),
            'title' => $this->tvShow->title,
            'description' => $this->tvShow->description,
            'slug' => $this->tvShow->slug,
            'tags' => $this->tvShow->tags,
            'thumbnail' => $this->tvShow->thumbnail,
            'release_date' => $this->tvShow->release_date,
            //'trailer' => $this->tvShow->trailer,
            'meta_title' => $this->tvShow->meta_title,
            'meta_description' => $this->tvShow->meta_description,
            'categories_id' => $this->tvShow->categories()->get()->pluck('id'),
            'casts_id' =>  $this->tvShow->casts()->get()->pluck('id'),
            'is_recommended' => $this->tvShow->is_recommended,
            'status' => $this->tvShow->status == 'published'
        ]);
    }

    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }

    public function submit(){

        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:tv_shows,slug,' . $this->tvShow->id,
            'description' => 'required',
            'release_date' => 'required|date',
            'thumbnail' => 'required',
            'categories_id' => 'required|array',
            'casts_id' => 'required|array',
            // 'trailer' => 'required',
            'tags' => 'array',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ],[
            'release_date.*' => 'Invalid Release Date Selected',
            'categories_id' => 'Select at least 1 category to continue',
            'casts_id' => 'Select at least 1 cast to continue'
        ]);


        try {
            $directory = 'videos';
            $files = Storage::disk('public')->allFiles($directory);

            foreach ($files as $file){
                if(Str::startsWith($file,$directory. "/". $this->tvShow->video->id)){
                    Storage::disk('public')->delete($file);
                }
            }

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

            throw_unless(TvShowRepository::updateTvShow($data, [
                'categories' => $this->categories_id,
                'casts' => $this->casts_id,
            ], $this->tvShow->id), "Please try again");

            toast()->success('Cheers!, Tv Show has been added')->pushOnNextPage();

            return redirect()->route('admin.tv-show.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.admin.shows.edit')->layout('layouts.admin-base');
    }
}
