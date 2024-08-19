<?php

namespace App\Http\Controllers\Api\V1\TvShow;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TvShow\ListResource;
use App\Models\TvShow;

class DetailController extends Controller
{
    public function __invoke(TvShow $tvShow)
    {

        $tvShow->load(['categories', 'casts']);
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::TV_SHOWS->value,
            'data' => new ListResource($tvShow)
        ]);

    }
}
