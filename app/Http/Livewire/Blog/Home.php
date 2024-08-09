<?php

namespace App\Http\Livewire\Blog;

use App\Http\Livewire\BaseComponent;
use Botble\Blog\Repositories\Eloquent\PostRepository;
use Botble\Blog\Models\Post;

class Home extends BaseComponent
{

    private $postRepo;

    public $perPage = 5;
    public $page = 1;


    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->postRepo = new PostRepository(new Post);
    }

    public function mount(){


        //$posts = $this->postRepo->getAllPosts($this->perPage, true);
    }

    public function loadMore()
    {

        $this->perPage += 5;


    }

    public function render()
    {
        return view('livewire.blog.home', ['posts' => $this->postRepo->getAllPosts($this->perPage,true)]);
    }
}
