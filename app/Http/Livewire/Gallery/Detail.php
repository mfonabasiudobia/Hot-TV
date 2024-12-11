<?php

namespace App\Http\Livewire\Gallery;

use Botble\Gallery\Models\Gallery;
use Livewire\Component;

class Detail extends Component
{
    public $photoGallery;
    public function mount(Gallery $gallery)
    {
        $this->photoGallery = $gallery;
    }

    public function render()
    {
        return view('livewire.gallery.detail', ['photoGallery' => $this->photoGallery]);
    }

}
