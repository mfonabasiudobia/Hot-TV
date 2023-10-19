<?php

namespace App\Http\Livewire\Admin\Podcast;

use App\Http\Livewire\BaseComponent;
use App\Repositories\PodcastRepository;

class Create extends BaseComponent
{

    public $title, $slug, $description, $thumbnail;

    public $meta_title, $meta_description, $recorded_video;

 
    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }


    public function submit(){
        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:podcasts,slug',
            'description' => 'required',
            'thumbnail' => 'required',
            'meta_title' => 'nullable',
            'recorded_video' => 'required',
            'meta_description' => 'nullable'
        ]);

        try {

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'thumbnail' => $this->thumbnail,
                'meta_title' => $this->meta_title,
                'recorded_video' => $this->recorded_video,
                'meta_description' => $this->meta_description
            ];

            throw_unless(PodcastRepository::createPodcast($data), "Please try again");

            toast()->success('Podcast has been added')->pushOnNextPage();

            return redirect()->route('admin.podcast.list');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.podcast.create')->layout('layouts.admin-base');
    }
}
