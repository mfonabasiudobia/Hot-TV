<?php

namespace App\Http\Livewire\User\Screenshots\Modal;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TravelRepository;

class UploadImage extends BaseComponent
{

    public $title, $image;

     public function updatedImage()
     {
        $this->validate([
            'image' => 'image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);
     }

    public function submit(){

        $this->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);


        $data = [
            'title' => $this->title,
            'image' => $this->image
        ];

        try {

            throw_unless(TravelRepository::customImageUpload($data, auth()->id()), "Failed to upload image");

            toast()->success('Image has been uploaded')->push();

            $this->dispatchBrowserEvent('trigger-close-modal');

            $this->reset();

        } catch (\Exception $e) {

            return toast()->danger($e->getMessage())->push();

        }

    }


    public function render()
    {
        return view('livewire.user.screenshots.modal.upload-image');
    }
}
