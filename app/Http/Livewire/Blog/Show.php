<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use Botble\Slug\Facades\SlugHelper;
use Botble\Blog\Models\Post;

class Show extends Component
{

    public $post;

    public function mount($slug){
         $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Post::class));

         if (!$slug) {
            abort(404);
         }

         $this->post = Post::findOrFail($slug->reference_id);
    }
    public function render()
    {
        return view('livewire.blog.show');
    }
}
