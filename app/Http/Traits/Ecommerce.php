<?php

namespace App\Http\Traits;

use Botble\Blog\Repositories\Eloquent\PostRepository;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\Wishlist;
use Botble\Base\Events\UpdatedContentEvent;
use Illuminate\Http\Request;
use Cart;

trait Ecommerce{

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

           $this->emit('refreshCart');
           
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }

    }

    public function saveToWishList($productId){
        try {
            
            $wishlist = Wishlist::where('product_id', $productId)->where('customer_id', auth()->id())->first();

            if(!$wishlist){
                Wishlist::create([ 'product_id' => $productId, 'customer_id' => auth()->id() ]);

                return toast()->success('Product has been added to wishlist')->push();
            }

            $wishlist->delete();

            toast()->success('Product has been removed from wishlist')->push();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

}
