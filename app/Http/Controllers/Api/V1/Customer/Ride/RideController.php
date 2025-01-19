<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function ongoing(Request $request)
    {
        $ride = Ride::where('user_id', $request->user()->id)
            ->whereIn('status', ['started', 'requested', 'accepted', 'driver-arrived'])
            ->with(['customer'])
            ->first();

        if($ride) {
            $message = 'ride.' . $ride->status;
            $data = ['id' => $ride->id];
        }

        return response()->json([
            'success' => true,
            'message' => $message ?? 'no-ride',
            'data' => $data ?? null
        ]);
    }
}
