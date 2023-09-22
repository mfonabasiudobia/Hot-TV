<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use Botble\Blog\Repositories\Eloquent\PostRepository;
use Botble\Ecommerce\Models\Product;
use Botble\Base\Events\UpdatedContentEvent;
use Illuminate\Http\Request;
use Cart;

class Home extends BaseComponent
{

      public function addToCart($product){
         try {

            Cart::instance('product')->content()->search(function ($cartItem, $rowId) use($product) {
            if($cartItem->id === $product['id']){
                throw_if($product['quantity'] < ($cartItem->qty + 1), "Max Quantity Reached");

                    return;
                }
            });

            Cart::instance('product')->add($product['id'], $product['name'], 1, $product['price'])->associate(Product::class);

           toast()->success('Product Added to Cart')->push();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }

    }

    public function render()
    {
        return view('livewire.product.home', ['products' => Product::published()->paginate(12)]);
    }
}
