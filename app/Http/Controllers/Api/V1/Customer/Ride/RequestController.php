<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Ride\DriverRideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Models\RideDuration;
use Illuminate\Support\Facades\Auth;
use App\Events\RideRequestEvent;
use App\Repositories\DriverRepository;

class RequestController extends Controller
{
    public function __invoke(Request $request)
    {
        $duration = $request->input('duration');
        $stream = $request->input('stream');
        $rideDuration = RideDuration::where('duration', $duration)->where('stream', $stream)->first();

        if(!$rideDuration) {
            return response()->json([
                'success' => false,
                'message' => 'No duration was found',
            ], 422);
        }

        $user = Auth::user();
        $streetName = $request->input('street_name');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');


        $rideRequest = $user->myRides()->create([
            'street_name' => $streetName,
            'price' => $rideDuration->price,
            'duration' => $rideDuration->duration,
            'ride_duration_id' => $rideDuration->id,
            'ride_type' => $rideDuration->stream ? 'Ride & Stream' : 'Ride Only',
            'stream' => $stream,
            'customer_latitude' => $latitude,
            'customer_longitude' => $longitude,
            // 'document_id' => $documentId
        ]);

        $driver = DriverRepository::getNextAvailableDriver($rideRequest);
        \Log::info('next driver', [$driver]);
        if($driver) {
            $driver->ride_responses()->create([
                'ride_id' => $rideRequest->id,
                'status' => DriverRideStatusEnum::PENDING,
            ]);

            event(new RideRequestEvent($rideRequest, $driver, $rideRequest->customer));
        }

        return response()->json([
            'success' => true,
            'message' => 'Ride request created',
            'data' => [
                'id' => $rideRequest->id,
                // 'document_id' => $documentId
            ]
        ]);
    }
}
