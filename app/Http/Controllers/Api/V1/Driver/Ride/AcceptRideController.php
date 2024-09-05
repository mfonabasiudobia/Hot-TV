<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;

class AcceptRideController extends Controller
{
    public function __invoke(Ride $ride)
    {
        $ride->status = StatusEnum::ACCEPTED->value;
        $ride->save();

        // Todo: trigger firebase event
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::RIDE_REQUESTED->value,
            // Todo: get the doc id from firebase
            // 'start_ride_collection_id' => $startCollectionDocId
        ]);

    }
}
