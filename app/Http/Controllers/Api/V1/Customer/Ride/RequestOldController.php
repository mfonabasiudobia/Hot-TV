<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Models\Ride;
use App\Models\RideBooking;
use App\Models\RideDuration;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Kreait\Firebase\Factory;


class RequestOldController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $factory = (new Factory)
                ->withServiceAccount(env('FIREBASE_CREDENTIALS'));

            // Access Firestore
            $firestore = $factory->createFirestore();
            $firestoreDatabase = $firestore->database();

            $duration = $request->input('duration');
            $stream = $request->input('stream');
            $rideDuration = RideDuration::where('duration', $duration)->where('stream', $stream)->first();

            $user = Auth::user();
            $streetName = $request->input('street_name');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $rideRequest = $user->myRides()->create([
                'street_name' => $streetName,
                'price' => $rideDuration->price,
                'duration' => $rideDuration->duration,
                'ride_duration_id' => $rideDuration->id,
                'ride_type' => $rideDuration->stream ? 'Ride & Stream' : 'Ride Only',
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            $rideData = [
                'customer_id' => 1,
                'driver_id' => 2,
                'customer_location' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
                'driver_location' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
                'status' => StatusEnum::REQUESTED->value
            ];

            // Add data to Firestore
            $rideCollection = $firestoreDatabase->collection('rides');
            $newRideDocument = $rideCollection->add($rideData);

            $docId = $newRideDocument->id();


            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::RIDE_REQUESTED->value,
                'data' => [
                    'collection_id' => $docId
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
