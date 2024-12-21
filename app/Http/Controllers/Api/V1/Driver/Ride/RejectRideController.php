<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Enums\Ride\DriverRideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\DriverRideRequest;
use App\Models\Ride;
use App\Repositories\DriverRepository;
use Illuminate\Support\Facades\Auth;
use App\Events\RideRequestEvent;

class RejectRideController extends Controller
{
    public function __invoke(Ride $ride, DriverRideRequest $request)
    {
        try {
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

            if($user->hasRejectedRide($ride)) {
                return response()->json([
                    'success' => false,
                    'message' => ApiResponseMessageEnum::RIDE_ALREADY_REJECTED->value,
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

            $user->ride_responses()->where('ride_id', $ride->id)->update([
                'status' => DriverRideStatusEnum::REJECTED,
            ]);

            $driver = DriverRepository::getNextAvailableDriver($ride);
            \Log::info('next driver in reject ride', [$driver]);
            if($driver) {
                $driver->ride_responses()->create([
                    'ride_id' => $ride->id,
                    'status' => DriverRideStatusEnum::PENDING,
                ]);

                event(new RideRequestEvent($ride, $driver, $ride->customer));
            }

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::RIDE_REJECTED->value,
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
