<?php

namespace App\Http\Livewire\Admin\Podcast;

use App\Http\Livewire\BaseComponent;
use App\Repositories\PodcastRepository;

class Edit extends BaseComponent
{

    public $title, $slug, $description, $thumbnail;

    public $podcast, $recorded_video;

    public $meta_title, $meta_description;


    public function mount($id){
        $this->podcast = PodcastRepository::getPodcastById($id);

        $this->fill([
            'title' => $this->podcast->title,
            'description' => $this->podcast->description,
            'slug' => $this->podcast->slug,
            'recorded_video' => $this->podcast->recorded_video,
            'thumbnail' => $this->podcast->thumbnail,
            'meta_title' => $this->podcast->meta_title,
            'meta_description' => $this->podcast->meta_description
        ]);
    }

    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }

    public function submit(){
        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:podcasts,slug,' . $this->podcast->id,
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
                'recorded_video' => $this->recorded_video,
                'thumbnail' => $this->thumbnail,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description
            ];

            throw_unless(PodcastRepository::updatePodcast($data, $this->podcast->id), "Please try again");

            toast()->success('Podcast has been updated')->pushOnNextPage();

            return redirect()->route('admin.podcast.list');
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.admin.podcast.edit')->layout('layouts.admin-base');
    }

}
