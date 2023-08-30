<?php

namespace App\Http\Livewire\User\Videos\Modal;

use App\Http\Livewire\BaseComponent;
use App\Repositories\VideoRepository;

class UploadVideo extends BaseComponent
{

    public $video_type = 'file', $title, $description, $thumbnail, $video_url, $video_file;


     public function updatedVideoFile()
     {
        $this->validate([
            'video_file' => 'file|mimes:mp4,m4v,webm,ogv,flv,mov|max:5120',
        ]);
     }

     public function updatedThumbnail()
     {
        $this->validate([
            'thumbnail' => 'image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);
     }

    public function submit(){

        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'video_type' => 'required|in:file,url',
            'video_url' => 'nullable',
            'video_file' => 'nullable|file|mimes:mp4,m4v,webm,ogv,flv,mov|max:5120',
            'thumbnail' => 'required|image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);


        $data = [
            'title' => $this->title,
            'video_type' => $this->video_type,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'video_url' => $this->video_url,
            'video_file' => $this->video_file
        ];

        try {

            throw_unless(VideoRepository::uploadVideo($data, auth()->id()), "Failed to upload video");

            toast()->success('Video request has been sent!')->push();

            $this->dispatchBrowserEvent('trigger-close-modal');

            $this->reset();

        } catch (\Exception $e) {

            return toast()->danger($e->getMessage())->push();

        }

    }


    public function render()
    {
        return view('livewire.user.videos.modal.upload-video');
    }
}
