<?php

namespace App\Http\Livewire\User\Screenshots\Modal;

use App\Http\Livewire\BaseComponent;
use App\Models\TravelPhoto;
use App\Repositories\TravelRepository;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Gallery\Models\GalleryMeta;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\Media\Models\MediaFolder;
use Botble\Gallery\Models\Gallery;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UploadImage extends BaseComponent
{

    public $title, $description, $images = [];
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatedImage()
     {
        $this->validate([
            'images.*' => 'image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);
     }

    public function submit(){

        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'images.*' => 'required|image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);

        $path = "screenshots/{$this->user->id}";
        $screenShotFolder = MediaFolder::updateOrCreate([
            'slug' => 'screenshots'
        ], [
            'name' => 'screenshots',
            'user_id' => 0,
            'parent_id' => 0,
        ]);

        $userFolder = MediaFolder::updateOrCreate([
            'slug' => "screenshots-{$this->user->id}"
        ], [
            'name' => $this->user->id,
            'user_id' => 0,
            'parent_id' => $screenShotFolder->id,
        ]);

        $uploadedImage = upload_gallery_file($this->images[0], $path);
        $gallery = Gallery::create([
            'name' => $this->title,
            'description' => $this->description,
            'is_featured' => 0,
            'image' => $uploadedImage['file_path'],
            'order' => 1,
            'user_id' => $this->user->id,
            'status' => BaseStatusEnum::PENDING()->getValue()
        ]);

        foreach($this->images as $image){
            $uploadedImage = upload_gallery_file($image, $path);
            $mediaImages[] = [
                'img' => $uploadedImage['file_path'],
                'description' => $uploadedImage['name']
            ];
            MediaFile::create([
                'user_id' => $this->user->id,
                'name' => MediaFile::createName($uploadedImage['name'], $userFolder->id),
                'alt' => $this->title,
                'folder_id' => $userFolder->id,
                'mime_type' => $uploadedImage['mime_type'],
                'size' => $uploadedImage['size'],
                'url' => $uploadedImage['file_path'],
                'type' => 'external'
            ]);
        }

        GalleryMeta::create([
            'images' => $mediaImages,
            'reference_id' => $gallery->id,
            'reference_type' => 'Botble\Gallery\Models\Gallery'
        ]);
        toast()->success('Image has been uploaded')->push();
        $this->dispatchBrowserEvent('trigger-close-modal');

        $this->title = null;
        $this->description = null;
        $this->images = [];
    }

    public function render()
    {
        return view('livewire.user.screenshots.modal.upload-image');
    }
}
