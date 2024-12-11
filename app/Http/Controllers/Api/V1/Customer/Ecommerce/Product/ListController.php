<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Product;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Ecommerce\ProductResource;
use Botble\Ecommerce\Models\Product;

class ListController extends Controller
{
    public function __invoke()
    {
        $products = Product::published()->where('is_variation', 0)->paginate(12);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PRODUCTS->value,
            'data' => [
                'products' => ProductResource::collection($products),
                'pagination' => customPagination($products)
            ]
        ]);
    }
}
