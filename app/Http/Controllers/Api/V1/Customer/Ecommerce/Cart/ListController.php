<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Cart;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
//use Cart as CartLibrary;
use App\Http\Resources\Api\V1\Customer\Ecommerce\CartResource;
use App\Http\Resources\Api\V1\Customer\Ecommerce\ProductResource;
use Gloudemans\Shoppingcart\Facades\Cart as CartLibrary;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        CartLibrary::instance('product')->restore($user->id . '_' . $user->username);
        $cart = CartLibrary::instance('product')->content();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::CART->value,
            'data' => [
                'cart' => CartResource::collection($cart),
                'sub_total' => getSubTotal($cart),
                'tax' => 0,
                'discount' => calculateDiscount($cart),
                'total' => CartLibrary::total(),
            ]
        ]);
    }
}
