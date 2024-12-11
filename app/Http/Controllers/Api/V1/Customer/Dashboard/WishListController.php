<?php

namespace App\Http\Controllers\Api\V1\Customer\Dashboard;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Dashboard\WishListResource;
use Botble\Ecommerce\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $wishlists = Wishlist::where('customer_id', $user->id)->paginate(12);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::WISH_LISTS->value,
            'data' => [
                'products' => WishListResource::collection($wishlists),
                'pagination' => customPagination($wishlists)

            ]
        ]);
    }
}
