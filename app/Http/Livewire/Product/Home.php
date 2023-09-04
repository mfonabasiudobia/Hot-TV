<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use Botble\Blog\Repositories\Eloquent\PostRepository;
use Botble\Blog\Models\Post;
use Botble\Ecommerce\Models\Product;

class Home extends BaseComponent
{

    private $postRepo;

    public function mount(){
        $this->postRepo = new PostRepository(new Post);

        // dd(get_products());
    }

    public function render()
    {
        return view('livewire.product.home', ['products' => Product::paginate(12)]);
    }
}
