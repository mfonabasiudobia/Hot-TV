<?php

namespace App\Http\Controllers\Api\V1\Customer\TvShow;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\TvShow\ShowCategoryResource;
use App\Models\ShowCategory;
use Botble\Base\Enums\BaseStatusEnum;

class CategoryController extends Controller
{
    public function __invoke()
    {
        $categories = ShowCategory::where('status', BaseStatusEnum::PUBLISHED()->getValue())->get();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::TV_SHOW_CATEGORIES->value,
            'data' => ShowCategoryResource::collection($categories)
        ]);
    }
}
