<?php

namespace App\Http\Controllers\Api\V1\TvShow;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TvShow\ShowCategoryResource;
use App\Models\ShowCategory;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Blog\Models\Category;

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
