<?php

namespace App\Http\Livewire\Blog;

use App\Http\Livewire\BaseComponent;
use Botble\Blog\Repositories\Eloquent\PostRepository;
use Botble\Blog\Models\Post;

class Home extends BaseComponent
{

    private $postRepo;

    public function mount(){
        $this->postRepo = new PostRepository(new Post);
    }

    public function render()
    {
        return view('livewire.blog.home', ['posts' => $this->postRepo->getAllPosts(12, true)]);
    }
}
