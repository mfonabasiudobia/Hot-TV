<?php

namespace App\Http\Livewire\User\Partials\Modal;

use App\Http\Livewire\BaseComponent;
use App\Repositories\TravelRepository;
use Botble\ACL\Models\User;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\Support\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UploadPic extends BaseComponent
{

    public $title, $avatar_file = null;

    public function updatedImage()
    {

        $this->validate([
            'images.*' => 'image|mimes:gif,jpg,jpeg,png|max:5120',
        ]);
    }

    public function submit(){

        $user = Auth::user();

        $avatarPath = "users";

        $profileAvatar = upload_avatar($this->avatar_file, $avatarPath);

        $media = MediaFile::create([
            'user_id' => $user->id,
            'name' => $profileAvatar,
            'alt'  => $profileAvatar,
            'folder_id' => 7,
            'mime_type' => $this->avatar_file->getMimetype(),
            'size' => $this->avatar_file->getSize(),
            'url' => $profileAvatar,
            'type' => 'internal'
        ]);

        $user->avatar_id = $media->id;
        $user->save();
        toast()->success('Image has been uploaded')->push();

        $this->dispatchBrowserEvent('trigger-close-modal');

        $this->emit('reRender');
    }


    public function render()
    {
        return view('livewire.user.partials.modal.upload-pic');
    }
}
