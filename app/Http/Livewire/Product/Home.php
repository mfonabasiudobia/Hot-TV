<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use Botble\Ecommerce\Models\Product;
use App\Http\Traits\Ecommerce;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;

class Home extends BaseComponent
{

    use Ecommerce;

    public $product;

    public function mount(){
        $slug = Slug::where('key', "products")->firstorFail();

        $this->product = Page::with(['meta'])->findOrFail($slug->reference_id);

    }

    public function render()
    {
        $products = Product::published()->paginate(12);

        return view('livewire.product.home', ['products' => $products])
        ->layout('layouts.app', [
            'seo_title' => $this->product->meta->meta_value[0]['seo_title'] ?? $this->product->name,
            'seo_description' => $this->product->meta->meta_value[0]['seo_description'] ?? ''
        ]);
    }
}
