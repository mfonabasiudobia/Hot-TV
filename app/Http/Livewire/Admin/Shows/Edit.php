<?php

namespace App\Http\Livewire\Admin\Shows;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TvShowRepository;
use App\Repositories\ShowCategoryRepository;

class Edit extends BaseComponent
{

    public $title, $slug, $description, $release_date, $thumbnail;

    public $categories = [], $categories_id = [], $tvShow;


    public function mount($id){
        $this->tvShow = TvShowRepository::getTvShowById($id);

        $this->fill([
            'categories' => ShowCategoryRepository::all(),
            'title' => $this->tvShow->title,
            'description' => $this->tvShow->description,
            'slug' => $this->tvShow->slug,
            'thumbnail' => $this->tvShow->thumbnail,
            'release_date' => $this->tvShow->release_date,
            'categories_id' => $this->tvShow->categories()->get()->pluck('id')
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
            'categories_id' => 'required|array'
        ],[
            'release_date.*' => 'Invalid Release Date Selected',
            'categories_id' => 'Select at least 1 category to continue'
        ]);

        try {

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'release_date' => $this->release_date,
                'thumbnail' => $this->thumbnail
            ];

            throw_unless(TvShowRepository::updateTvShow($data, $this->categories_id, $this->tvShow->id), "Please try again");

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
