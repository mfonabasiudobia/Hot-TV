<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Ride\DriverRideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Jobs\ProcessRideRequest;
use App\Models\RideDuration;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Events\RideRequestEvent;
use App\Repositories\DriverRepository;

class RequestController extends Controller
{
    public function __invoke(Request $request)
    {
        // $serviceAccountKeyFile = config('services.firebase.credentials');

        // $scopes = ['https://www.googleapis.com/auth/datastore'];

        // // Create a credentials object with the service account file and the scope
        // $credentials = new ServiceAccountCredentials($scopes, $serviceAccountKeyFile);

        // Fetch the OAuth2 token
        // $accessToken = $credentials->fetchAuthToken();

        // if (isset($accessToken['access_token'])) {

            // $tokenString = $accessToken['access_token'];

            $duration = $request->input('duration');
            $stream = $request->input('stream');
            $rideDuration = RideDuration::where('duration', $duration)->where('stream', $stream)->first();

            if(!$rideDuration) {
                return response()->json([
                    'success' => false,
                    'message' => 'No duration was found',
                ], 422);
            }

            $user = Auth::user();
            $streetName = $request->input('street_name');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            // $rideData = [
            //     'fields' => [
            //         'customer_id' => ['integerValue' => $user->id],
            //         'customer_location' => [
            //             'mapValue' => [
            //                 'fields' => [
            //                     'latitude' => ['doubleValue' => $latitude],
            //                     'longitude' => ['doubleValue' => $longitude],
            //                 ]
            //             ]
            //         ],
            //         'status' => ['stringValue' => StatusEnum::REQUESTED->value],
            //     ]
            // ];

            // Use the access token to make an authenticated request to Firestore
            // $response = Http::withToken($tokenString)
            //     ->post('https://firestore.googleapis.com/v1/projects/hot-tv-a57ea/databases/(default)/documents/rides', $rideData);
            // $documentName = $response->json()['name'];
            // $documentId = last(explode('/', $documentName));

            // if ($response->successful()) {

                $rideRequest = $user->myRides()->create([
                    'street_name' => $streetName,
                    'price' => $rideDuration->price,
                    'duration' => $rideDuration->duration,
                    'ride_duration_id' => $rideDuration->id,
                    'ride_type' => $rideDuration->stream ? 'Ride & Stream' : 'Ride Only',
                    'customer_latitude' => $latitude,
                    'customer_longitude' => $longitude,
                    // 'document_id' => $documentId
                ]);

                // $firestoreUrl = "https://firestore.googleapis.com/v1/projects/hot-tv-a57ea/databases/(default)/documents/rides/{$documentId}?updateMask.fieldPaths=ride_id";

                // $updateData = [
                //     "fields" => [
                //         "ride_id" => ["integerValue" => $rideRequest->id],
                //     ]
                // ];

                // $riders = DriverRepository::onlineRiders($rideRequest);
                // dispatch(new ProcessRideRequest($rideRequest, $riders, $rideRequest->customer));

                $driver = DriverRepository::getNextAvailableDriver($rideRequest);
                if($driver) {
                    $driver->ride_responses()->create([
                        'ride_id' => $rideRequest->id,
                        'status' => DriverRideStatusEnum::PENDING,
                    ]);
                }

                event(new RideRequestEvent($rideRequest, $driver, $rideRequest->user_id));

                // $response = Http::withToken($tokenString)
                //     ->patch($firestoreUrl, $updateData);


                return response()->json([
                    'success' => true,
                    'message' => 'Ride request created',
                    'data' => [
                        'id' => $rideRequest->id,
                        // 'document_id' => $documentId
                    ]
                ]);
            // } else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Failed to create ride request',
            //         'error' => $response->body()
            //     ], $response->status());
            // }
        // } else {
        //     // Handle the case where the access token could not be generated
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Failed to generate access token',
        //         'error' => 'OAuth token generation failed'
        //     ], 500);
        // }
    }
}
