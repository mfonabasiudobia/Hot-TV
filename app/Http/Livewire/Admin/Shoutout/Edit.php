<?php

namespace App\Http\Livewire\Admin\Shoutout;

use App\Http\Livewire\BaseComponent;
use App\Repositories\PodcastRepository;
use App\Repositories\ShoutoutRepository;

class Edit extends BaseComponent
{

    public $title, $slug, $description, $thumbnail;

    public $shoutout, $recorded_video, $media_image, $media_type;

    public $meta_title, $meta_description;


    public function mount($id){
        $this->shoutout = ShoutoutRepository::getById($id);

        $this->fill([
            'title' => $this->shoutout->title,
            'description' => $this->shoutout->description,
            'slug' => $this->shoutout->slug,
            'recorded_video' => $this->shoutout->media_type == 'video' ? $this->shoutout->media_url : null,
            'media_image' => $this->shoutout->media_type == 'image' ? $this->shoutout->media_url : null,
            'media_type' => $this->shoutout->media_type,
            'thumbnail' => $this->shoutout->thumbnail,
            'meta_title' => $this->shoutout->meta_title,
            'meta_description' => $this->shoutout->meta_description
        ]);

    }


    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }

    public function submit(){


        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:shoutouts,slug,' . $this->shoutout->id,
            'description' => 'required',
            'thumbnail' => 'required',
            'recorded_video' => 'nullable',
            'media_image' => 'nullable',
            'media_type' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable'
        ]);

        try {

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'media_url' => $this->media_type == 'image' ? $this->media_image : $this->recorded_video,
                'media_type' => $this->media_type,
                'thumbnail' => $this->thumbnail,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description
            ];


            throw_unless(ShoutoutRepository::update($data, $this->shoutout->id), "Please try again");

            toast()->success('Podcast has been updated')->pushOnNextPage();

            return redirect()->route('admin.shoutout.list');
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.shoutout.edit')->layout('layouts.admin-base');
    }

}
