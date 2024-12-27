<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RideListController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        // $autoRejected = $ride->ride_responses()->where('driver_id', $user->id)->where('status', DriverRideStatusEnum::AUTO_REJECTED)->first();

        $responses = $user->ride_responses()->with("ride")->get();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::RIDE_ACCEPTED->value,
            'data' => [
                'rides' => $responses
            ]
        ]);
    }
}
