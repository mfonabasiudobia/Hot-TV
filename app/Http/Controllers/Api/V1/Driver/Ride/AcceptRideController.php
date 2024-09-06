<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\DriverRideRequest;
use App\Models\Ride;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AcceptRideController extends Controller
{
    public function __invoke(Ride $ride, DriverRideRequest $request)
    {

        $serviceAccountKeyFile = config('services.firebase.credentials');

        $scopes = ['https://www.googleapis.com/auth/datastore'];

        $credentials = new ServiceAccountCredentials($scopes, $serviceAccountKeyFile);

        $accessToken = $credentials->fetchAuthToken();

        if (isset($accessToken['access_token'])) {
            $tokenString = $accessToken['access_token'];

            $user = Auth::user();

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $firestoreUrl = "https://firestore.googleapis.com/v1/projects/hot-tv-a57ea/databases/(default)/documents/rides/{$ride->document_id}?updateMask.fieldPaths=driver_id&updateMask.fieldPaths=status&updateMask.fieldPaths=driver_location";

            $updateData = [
                "fields" => [
                    "driver_id" => ["integerValue" => $user->id],
                    "status" => ["stringValue" => StatusEnum::ACCEPTED->value],
                    "driver_location" => [
                        "mapValue" => [
                            "fields" => [
                                "latitude" => ["doubleValue" =>$latitude],
                                "longitude" => ["doubleValue" => $longitude],
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withToken($tokenString)
            ->patch($firestoreUrl, $updateData);

            if ($response->successful()) {

                $ride->driver_latitude = $latitude;
                $ride->driver_longitude = $longitude;
                $ride->status = StatusEnum::ACCEPTED->value;
                $ride->driver_id = $user->id;

                $ride->save();

                return response()->json([
                    'success' => true,
                    'message' => ApiResponseMessageEnum::RIDE_REQUESTED->value,
                    'data' => [
                        'id' => $ride->id,
                        'document_id' => $ride->document_id
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update ride request',
                    'error' => $response->body()
                ], $response->status());
            }


        } else {
            // Handle the case where the access token could not be generated
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate access token',
                'error' => 'OAuth token generation failed'
            ], 500);
        }


    }
}
