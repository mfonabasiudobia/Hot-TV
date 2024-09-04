<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Ride\DurationResource;
use App\Models\RideDuration;

class DurationController extends Controller
{
    public function __invoke()
    {
        $durations = RideDuration::all();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::RIDE_DURATIONS->value,
            'data' => [
                'durations' => DurationResource::collection($durations)
            ]
        ]);
    }
}
