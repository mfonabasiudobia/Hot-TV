<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Models\Ride;
use App\Models\RideBooking;
use App\Models\RideDuration;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class RequestController extends Controller
{
    public function __invoke(Request $request)
    {

        $duration = $request->input('duration');
        $stream = $request->input('stream');
        $rideDuration = RideDuration::where('duration', $duration)->where('stream', $stream);

        $user = Auth::user();
        $streetName = $request->input('street_name');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $ride_duration_id = $rideDuration->id;

        $rideDuration = RideDuration::find($ride_duration_id);

        $rideRequest = $user->myRides()->create([
            'street_name' => $streetName,
            'price' => $rideDuration->price,
            'duration' => $rideDuration->duration,
            'ride_duration_id'=> $rideDuration->id,
            'ride_type' =>  $rideDuration->stream ? 'Ride & Stream' : 'Ride Only',
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        // Todo: trigger firebase event

        // Todo: get the docId and save into rides tables
        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::RIDE_REQUESTED->value,
            'data' => [
                // 'collection_id' => $docID
            ]
        ]);
    }
}
