<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\Ride\StatusEnum;
use App\Enums\Ride\DriverRideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Ride\DriverRideRequest;
use App\Models\User;
use App\Models\Ride;
use App\Events\RideAccepted;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RejectRideController extends Controller
{
    public function __invoke(Ride $ride, DriverRideRequest $request)
    {

        // $serviceAccountKeyFile = base_path('firebase_credentials.json');
        // $firsBaseProjectId = config('services.firebase.project_id');
        // $scopes = ['https://www.googleapis.com/auth/datastore'];

        // $credentials = new ServiceAccountCredentials($scopes, $serviceAccountKeyFile);

        // $accessToken = $credentials->fetchAuthToken();

        // if (isset($accessToken['access_token'])) {
        //     $tokenString = $accessToken['access_token'];

            $user = Auth::user();

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            // $firestoreUrl = "https://firestore.googleapis.com/v1/projects/$firsBaseProjectId/databases/(default)/documents/rides/{$ride->document_id}?updateMask.fieldPaths=driver_id&updateMask.fieldPaths=status&updateMask.fieldPaths=driver_location";

            // $updateData = [
            //     "fields" => [
            //         "driver_id" => ["integerValue" => $user->id],
            //         "status" => ["stringValue" => StatusEnum::ACCEPTED->value],
            //         "driver_location" => [
            //             "mapValue" => [
            //                 "fields" => [
            //                     "latitude" => ["doubleValue" =>$latitude],
            //                     "longitude" => ["doubleValue" => $longitude],
            //                 ]
            //             ]
            //         ]
            //     ]
            // ];

            // $response = Http::withToken($tokenString)
            // ->patch($firestoreUrl, $updateData);

            // if ($response->successful()) {
            if(! $user->hasRideEntry($ride)){
                return response()->json([
                    'success' => true,
                    'message' => ApiResponseMessageEnum::RIDE_RESPONSE_ENTRY_MISSING->value,
                    'data' => [
                        'id' => $ride->id,
                        'document_id' => $ride->document_id
                    ]
                ]);
            }

            if($user->hasRejectedRide($ride)) {
                return response()->json([
                    'success' => true,
                    'message' => ApiResponseMessageEnum::RIDE_ALREADY_REJECTED->value,
                    'data' => [
                        'id' => $ride->id,
                        'document_id' => $ride->document_id
                    ]
                ]);
            }

            if($ride->status == StatusEnum::ACCEPTED) {
                return response()->json([
                    'success' => true,
                    'message' => ApiResponseMessageEnum::RIDE_ALREADY_ACCEPTED->value,
                    'data' => [
                        'id' => $ride->id,
                        'document_id' => $ride->document_id
                    ]
                ]);
            }

            $user->ride_responses()->where('ride_id', $ride->id)->update([
                'status' => DriverRideStatusEnum::REJECTED,
            ]);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::RIDE_REQUESTED->value,
                'data' => [
                    'id' => $ride->id,
                    'document_id' => $ride->document_id
                ]
            ]);
            // } else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Failed to update ride request',
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
