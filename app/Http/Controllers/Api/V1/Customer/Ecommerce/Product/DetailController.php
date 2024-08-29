<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Product;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Ecommerce\ProductResource;
use Botble\Ecommerce\Models\Product;

class DetailController extends Controller
{
    public function __invoke(Product $product)
    {
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PRODUCT->value,
            'data' => new ProductResource($product),
        ]);
    }
}
