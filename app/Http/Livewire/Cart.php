<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\Address;
use Cart as CartLibrary;

class Cart extends BaseComponent
{

    public $carts = [];

    public function mount(){
        // CartLibrary::instance('product')->destroy();
        $this->fill([
            'carts' => CartLibrary::instance('product')->content()
        ]);
    }

    public function removeFromCart($rowId){
        CartLibrary::instance('product')->remove($rowId);
    }

    public function addToCart($product, $qty = 1){
        try {
            throw_if($qty < 1, 'Invalid Quantity Supplied');

            CartLibrary::instance('product')->content()->search(function ($cartItem, $rowId) use($product, $qty) {
            if($cartItem->id === $product['id']){
                throw_if($product['quantity'] < $qty, "Max Quantity Reached");

                    return;
                }
            });

            CartLibrary::instance('product')->add($product['id'], $product['name'], 1, $product['price'])->associate(Product::class);

            toast()->success('Product Added to Cart')->push();

            $this->emit('refreshCart');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function lessFromCart($product, $qty = 1){
        try {
            throw_if($qty < 1, 'Invalid Quantity Supplied');

            CartLibrary::instance('product')->content()->search(function ($cartItem, $rowId) use($product, $qty) {
            if($cartItem->id === $product['id']){
                throw_if($product['quantity'] < $qty, "Max Quantity Reached");

                    return;
                }
            });

            CartLibrary::instance('product')->add($product['id'], $product['name'], -1, $product['price'])->associate(Product::class);

            toast()->success('Quantity removed from Cart')->push();

            $this->emit('refreshCart');

        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
