<?php

namespace App\Http\Controllers\Api\V1\Customer\LiveChannel;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\LiveChannel\StreamResource;
use App\Models\Stream;

class ShowController extends Controller
{
    public function __invoke(Stream $stream)
    {
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::STREAMS->value,
            'data' => new StreamResource($stream),
        ]);
    }
}
