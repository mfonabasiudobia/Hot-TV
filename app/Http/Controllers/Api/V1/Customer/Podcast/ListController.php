<?php

namespace App\Http\Controllers\Api\V1\Customer\Podcast;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Podcast\PodcastResource;
use App\Models\Podcast;
use Botble\Base\Enums\BaseStatusEnum;

class ListController extends Controller
{
    public function __invoke()
    {
        $pageSize = 20;
        $podcasts = Podcast::where('status', BaseStatusEnum::PUBLISHED()->getValue())->paginate($pageSize);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PODCASTS->value,
            'data' => [
                'podcasts' => PodcastResource::collection($podcasts),
                'pagination' => customPagination($podcasts)
            ]
        ]);

    }
}
