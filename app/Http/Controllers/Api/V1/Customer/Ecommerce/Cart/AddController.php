<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Cart;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ecommerce\AddToCardRequest;
use Botble\Ecommerce\Models\Product;
//use Cart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class AddController extends Controller
{
    public function __invoke(AddToCardRequest $request)
    {

        $user = Auth::user();
        $qty = $request->input('qty');
        $productId = $request->input('product_id');

        $product = Product::where('id', $productId)->first();


        Cart::instance('product')->restore($user->id . '_' . $user->username);
        Cart::instance('product')->content()->search(function ($cartItem) use ($product, $qty) {

            if($cartItem->id === $product->id){
                if($product->quantity < $cartItem->qty + $qty) {
                    return response()->json([
                        'success' => false,
                        'message' => ApiResponseMessageEnum::MAX_QUANTITY_REACHED->value
                    ], 422);
                }
            }
        });

        $prices = getProductSalePrice($product);
        $price = $prices['price'];
        $oldPrice = $prices['old_price'];

        Cart::instance('product')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $price,
            'options' => [ 'old_price' => $oldPrice ]
        ])->associate(Product::class);
        Cart::instance('product')->store($user->id . '_' . $user->username);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PRODUCT_ADDED_SUCCESS->value,
        ]);
    }
}
