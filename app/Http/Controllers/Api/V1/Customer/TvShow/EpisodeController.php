<?php

namespace App\Http\Controllers\Api\V1\Customer\TvShow;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\TvShow\EpisodeResource;
use App\Models\Episode;

class EpisodeController extends Controller
{
    public function __invoke(Episode $episode)
    {
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::EPISODE->value,
            'data' => new EpisodeResource($episode)
        ]);
    }
}
