<?php

namespace App\Http\Livewire\Categories;

use Botble\Blog\Models\Category;
use Livewire\Component;
use Botble\Slug\Facades\SlugHelper;
use Botble\Blog\Models\Post;

class Show extends Component
{

    public $posts;
    public $category;

    public function mount($id){
         $this->category = Category::find($id);

         if (!$this->category) {
            abort(404);
         }
    }
    public function render()
    {
        return view('livewire.categories.show');
    }
}
