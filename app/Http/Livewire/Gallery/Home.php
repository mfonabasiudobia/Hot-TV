<?php

namespace App\Http\Livewire\Gallery;

use \Botble\Gallery\Models\Gallery;
use Botble\Gallery\Models\GalleryMeta;
use Livewire\Component;

class Home extends Component
{

    public function render()
    {
        $photoGallery = Gallery::where('user_id', '!=', 1)
            ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED()->getValue())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.gallery.home', ['photoGallery' => $photoGallery]);
    }
}
