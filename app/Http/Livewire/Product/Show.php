<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use Botble\Slug\Facades\SlugHelper;
use Botble\Ecommerce\Models\Product;
use Botble\Slug\Models\Slug;
use Cart;

class Show extends BaseComponent
{

    public $product;

    public function mount($slug){
         $slug = Slug::where('key', $slug)->firstorFail();

         $this->product = Product::findOrFail($slug->reference_id);
    }

    public function addToCart($product, $qty = 1){

        try {

            throw_if($qty < 1, 'Invalid Quantity Supplied');

            Cart::instance('product')->content()->search(function ($cartItem, $rowId) use($product, $qty) {
            if($cartItem->id === $product['id']){
                throw_if($product['quantity'] < ($cartItem->qty + $qty), "Max Quantity Reached");

                    return;
                }
            });

            Cart::instance('product')->add($product['id'], $product['name'], $qty, $product['price'])->associate(Product::class);

            toast()->success('Product Added to Cart')->push();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }

    }


    public function render()
    {
        return view('livewire.product.show');
    }
}
