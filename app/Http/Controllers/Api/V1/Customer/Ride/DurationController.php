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
        $durations = RideDuration::select('duration')
            ->groupBy('duration') // Group by the duration text
            ->get()
            ->map(function ($item) {
                return [
                    'duration' => $item->duration,
                    'price_with_stream' => RideDuration::where('duration', $item->duration)
                        ->where('stream', true)
                        ->value('price'),
                    'price_without_stream' => RideDuration::where('duration', $item->duration)
                        ->where('stream', false)
                        ->value('price'),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::RIDE_DURATIONS->value,
            'data' => [
                'durations' => $durations
            ]
        ]);
    }
}
