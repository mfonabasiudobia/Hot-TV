<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function ongoing(Request $request)
    {
        $ride = Ride::where('driver_id', $request->user()->id)
            ->whereIn('status', ['started', 'accepted', 'driver-arrived'])
            ->with(['customer'])
            ->first();

        if($ride) {
            $message = 'ride.' . $ride->status;

            if($ride->status === 'driver-arrived') {
                $message = 'driver.arrived';
            }

            $data = ['ride' => $ride, 'driver' => $ride->driver, 'customer' => $ride->customer];
        }

        return response()->json([
            'success' => true,
            'message' => $message ?? 'no-ride',
            'data' => $data ?? null
        ]);
    }
}
