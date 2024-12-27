<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

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

            $user = auth()->user(); // Get the logged-in customer

            // Update the user's location in the database (optional)
            $user->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // If customer has an ongoing ride request, broadcast location to the assigned driver
            $ride = Ride::where('customer_id', $user->id)->whereIn('status', ['requested', 'in_progress'])->first();
            if ($ride) {
                // Broadcast the location to the driver
                event(new LocationUpdated($user->id, $validated['latitude'], $validated['longitude'], 'driver'));
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
