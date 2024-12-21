<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Enums\Ride\DriverRideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\DriverRideRequest;
use App\Models\User;
use App\Models\Ride;
use App\Events\RideAccepted;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AcceptRideController extends Controller
{
    public function __invoke(Ride $ride, DriverRideRequest $request)
    {
        $user = Auth::user();

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        if(! $user->hasRideEntry($ride)){
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::RIDE_RESPONSE_ENTRY_MISSING->value,
                'data' => [
                    'id' => $ride->id,
                    'document_id' => $ride->document_id
                ]
            ]);
        }

        if($ride->status == StatusEnum::ACCEPTED) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::RIDE_ALREADY_ACCEPTED->value,
                'data' => [
                    'id' => $ride->id,
                    'document_id' => $ride->document_id
                ]
            ]);
        }

        $autoRejected = $ride->ride_responses()->where('user_id', $user->id)->where('status', DriverRideStatusEnum::AUTO_REJECTED)->first();

        if($autoRejected) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::RIDE_AUTOREJECTED->value,
                'data' => [
                    'id' => $ride->id
                ]
            ]);
        }

        $ride->driver_latitude = $latitude;
        $ride->driver_longitude = $longitude;
        $ride->status = StatusEnum::ACCEPTED->value;
        $ride->driver_id = $user->id;

        $ride->save();

        $user->ride_responses()->where('ride_id', $ride->id)->update([
            'status' => DriverRideStatusEnum::ACCEPTED,
        ]);

        event(new RideAccepted($ride, $ride->driver, $ride->customer));

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::RIDE_ACCEPTED->value,
            'data' => [
                'id' => $ride->id,
                'document_id' => $ride->document_id
            ]
        ]);
    }
}
