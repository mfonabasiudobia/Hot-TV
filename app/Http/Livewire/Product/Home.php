<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use Botble\Ecommerce\Models\Product;
use App\Http\Traits\Ecommerce;

class Home extends BaseComponent
{

    use Ecommerce;
    
    public function render()
    {
        return view('livewire.product.home', ['products' => Product::published()->paginate(12)]);
    }
}
