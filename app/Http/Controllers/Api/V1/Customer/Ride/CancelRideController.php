<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Models\Ride;
use App\Events\RideCancelled;
use App\Http\Controllers\Controller;
use App\Enums\Ride\StatusEnum;

class CancelRideController extends Controller
{
    public function __invoke(Ride $ride)
    {
        try {
            if($ride->status == StatusEnum::ACCEPTED) {
               event(new RideCancelled($ride));
            }else if($ride->status == StatusEnum::REQUESTED) {
                //
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Ride cannot be cancelled, because its in status' . $ride->status,
                    'data' => [
                        'id' => $ride->id,
                    ]
                ]);
            }

            $ride->status = StatusEnum::CANCELLED->value;
            $ride->save();

            return response()->json([
                'success' => true,
                'message' => 'Ride request cancelled',
                'data' => [
                    'id' => $ride->id,
                ]
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
