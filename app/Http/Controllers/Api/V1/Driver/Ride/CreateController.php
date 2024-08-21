<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\CreateRequest;
use App\Models\Ride;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    public function __invoke(CreateRequest $request)
    {

        $user = Auth::user();
        $street_name = $request->input('street_name');
        $price = $request->input('price');
        $duration = $request->input('duration');
        $details = $request->input('details');
        $ride_type = $request->input('ride_type');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $ride = $user->rides()->create([
            'street_name' => $street_name,
            'price' => $price,
            'duration' => $duration,
            'details' => $details,
            'ride_type' => $ride_type,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);

        return $ride;
    }
}
