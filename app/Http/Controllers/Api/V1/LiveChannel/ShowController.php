<?php

namespace App\Http\Controllers\Api\V1\LiveChannel;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TvShow\ListResource;
use App\Models\Stream;

class ShowController extends Controller
{
    public function __invoke(Stream $stream)
    {
//        $pageSize = 20;
//        $streams = Stream::orderBy('created_at', 'desc')->paginate($pageSize);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::STREAMS->value,
            'data' => new ListResource($stream),
        ]);


    }
}
