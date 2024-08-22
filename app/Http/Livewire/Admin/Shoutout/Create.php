<?php

namespace App\Http\Livewire\Admin\Shoutout;

use App\Http\Livewire\BaseComponent;
use App\Repositories\ShoutoutRepository;
use Botble\Base\Enums\BaseStatusEnum;

class Create extends BaseComponent
{
    public $title, $slug, $description, $thumbnail;
    public $meta_title, $meta_description, $media_type = 'image', $recorded_video, $media_image, $status;

    public function updatedTitle($title){
        $this->slug = str()->slug($title);
    }

    public function submit(){
        $this->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:shoutouts,slug',
            'description' => 'required',
            'thumbnail' => 'required_if:media_type,video',
            'recorded_video' => 'required_if:media_type,video',
            'media_image' => 'required_if:media_type,image',
            'media_type' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable'
        ]);

        try {
            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'thumbnail' => $this->thumbnail,
                'media_url' => $this->media_type == 'image' ? $this->media_image : $this->recorded_video,
                'media_type' => $this->media_type,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'status' => $this->status ? BaseStatusEnum::PUBLISHED()->getValue() : BaseStatusEnum::DRAFT()->getValue()
            ];

            throw_unless(ShoutoutRepository::create($data), "Please try again");
            toast()->success('Podcast has been added')->pushOnNextPage();
            return redirect()->route('admin.shoutout.list');
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {   $this->status = BaseStatusEnum::PUBLISHED()->getValue();
        return view('livewire.admin.shoutout.create')->layout('layouts.admin-base');
    }
}
