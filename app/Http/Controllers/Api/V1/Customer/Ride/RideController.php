<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Events\DriverArrived;
use App\Events\RideAccepted;
use App\Events\RideSearching;
use App\Events\RideStarted;
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
            switch($ride->status) {
                case 'requested':
                    event(new RideSearching($ride, $ride->driver ?? null, $ride->customer));
                    break;
                case 'started':
                    event(new RideStarted($ride, $ride->driver ?? null, $ride->customer));
                    break;
                case 'accepted':
                    event(new RideAccepted($ride, $ride->driver ?? null, $ride->customer));
                    break;
                case 'driver-arrived':
                    event(new DriverArrived($ride, $ride->driver ?? null, $ride->customer));
                    break;
                default:
                    break;
            }

        }


        return response()->json([
            'success' => true,
            'message' => 'Inprogress ride',
            'data' => [
                'ride' => $ride,
            ]
        ]);
    }
}
