<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\DriverRideRequest;
use App\Models\Ride;
use App\Events\RideStarted;
use Illuminate\Support\Facades\Auth;

class StartRideController extends Controller
{
    public function __invoke(Ride $ride, DriverRideRequest $request)
    {
        try {
            $user = Auth::user();

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $rideEvent = [
                'ride_id' => $ride->id,
                'user_latitude' => $latitude,
                'user_longitude' => $longitude,
                'event_timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
                'event_type' => StatusEnum::STARTED->value
            ];

            $event = $ride->ride_events()->create($rideEvent);

            $ride->status = StatusEnum::STARTED->value;
            $ride->driver_id = $user->id;

            $ride->save();

            event(new RideStarted($ride, $ride->driver, $ride->customer));

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::RIDE_STARTED->value,
                'data' => [
                    'id' => $ride->id,
                    'document_id' => $ride->document_id
                ]
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }
}
