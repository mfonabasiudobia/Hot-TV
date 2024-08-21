<?php

namespace App\Http\Controllers\Api\V1\Customer\Podcast;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Podcast\PodcastResource;
use App\Models\Podcast;

class ShowController extends Controller
{
    public function __invoke(Podcast $podcast)
    {
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PODCAST->value,
            'data' => new PodcastResource($podcast),
        ]);
    }
}

