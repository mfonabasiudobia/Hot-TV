<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\DriverRideRequest;
use App\Models\Ride;
use App\Models\User;
use App\Events\RideCompleted;
use Carbon\Carbon;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CompleteRideController extends Controller
{
    public function __invoke(Ride $ride, DriverRideRequest $request)
    {
            $user = Auth::user();

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $rideEvent = [
                'ride_id' => $ride->id,
                'user_latitude' => $latitude,
                'user_longitude' => $longitude,
                'event_timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
                'event_type' => StatusEnum::COMPLETED->value
            ];

            $event = $ride->ride_events()->create($rideEvent);

            $ride->status = StatusEnum::COMPLETED->value;
            $ride->driver_id = $user->id;
            $ride->stream_status = 'completed';

            $ride->save();

            event(new RideCompleted($ride, $ride->driver, $ride->customer));

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::RIDE_COMPLETED->value,
                'data' => [
                    'id' => $ride->id,
                    'document_id' => $ride->document_id
                ]
            ]);
    }
}
