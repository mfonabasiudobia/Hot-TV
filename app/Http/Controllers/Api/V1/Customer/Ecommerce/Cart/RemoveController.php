<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Cart;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class RemoveController extends Controller
{
    public function __invoke($rowId)
    {
        $user = Auth::user();
        Cart::instance('product')->restore($user->id . '_' . $user->username);

        Cart::instance('product')->remove($rowId);
        Cart::instance('product')->store($user->id . '_' . $user->username);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::ITEM_REMOVED_FROM_CART->value,
        ]);
    }
}
