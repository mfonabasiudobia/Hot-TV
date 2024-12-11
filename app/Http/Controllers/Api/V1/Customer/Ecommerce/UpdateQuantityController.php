<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ecommerce\UpdateQuantityRequest;
use Botble\Ecommerce\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class UpdateQuantityController extends Controller
{
    public function __invoke(UpdateQuantityRequest $request, Product $product, $rowId)
    {

        $user = Auth::user();
        $qty = $request->input('quantity');

        Cart::instance('product')->restore($user->id . '_' . $user->username);

        if($product->quantity < $qty) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::MAX_QUANTITY_REACHED->value
            ], 422);
        }

        Cart::instance('product')->update($rowId, $qty);
        Cart::instance('product')->store($user->id . '_' . $user->username);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::CART_UPDATED->value,
        ]);

    }
}
