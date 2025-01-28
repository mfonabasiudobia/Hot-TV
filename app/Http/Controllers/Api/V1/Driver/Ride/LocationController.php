<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Events\LocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __invoke(Ride $ride, $request)
    {
        try {
            $validated = $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $user = auth('api')->user();

            $user->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            $ride = Ride::where('driver_id', $user->id)->whereIn('status', ['requested', 'in_progress'])->first();

            if ($ride) {
                event(new LocationUpdated($user->id, $validated['latitude'], $validated['longitude'], 'customer'));
            }

            if ($user->online_status) {
                event(new LocationUpdated($user->id, $validated['latitude'], $validated['longitude'], 'admin'));
            }

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::LOCATION_UPDATED->value,
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
