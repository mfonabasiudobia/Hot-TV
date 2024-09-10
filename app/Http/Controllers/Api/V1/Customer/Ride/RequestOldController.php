<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Ride\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Models\RideDuration;
use App\Services\FireStoreService;
use App\Services\NotificationService;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RequestOldController extends Controller
{
    public $notificationService;

    public $firestoreService;

    public function __construct(FirestoreService $firestoreService, NotificationService $notificationService)
    {

        $this->firestoreService = $firestoreService;
        $this->notificationService = $notificationService;
    }

    public function __invoke(Request $request)
    {

        //$serviceAccountKeyFile = base_path('firebase_credentials.json');
        //$firsBaseProjectId = config('services.firebase.project_id');
        //$scopes = ['https://www.googleapis.com/auth/datastore'];

        // Create a credentials object with the service account file and the scope
        //$credentials = new ServiceAccountCredentials($scopes, $serviceAccountKeyFile);

        // Fetch the OAuth2 token
//        $accessToken = $credentials->fetchAuthToken();
//
//        if (isset($accessToken['access_token'])) {







            return DB::transaction(function() use ($request) {
                $user = Auth::user();
                //$tokenString = $accessToken['access_token'];

                $duration = $request->input('duration');
                $stream = $request->input('stream');
                $rideDuration = RideDuration::where('duration', $duration)->where('stream', $stream)->first();

                if(!$rideDuration) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create ride request',
                    ]);
                }

                $streetName = $request->input('street_name');
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');

                $rideRequest = $user->myRides()->create([
                    'street_name' => $streetName,
                    'price' => $rideDuration->price,
                    'duration' => $rideDuration->duration,
                    'ride_duration_id' => $rideDuration->id,
                    'ride_type' => $rideDuration->stream ? 'Ride & Stream' : 'Ride Only',
                    'customer_latitude' => $latitude,
                    'customer_longitude' => $longitude,
                ]);


                try{
                    $documentId = $this->firestoreService->createRideDocument($rideRequest);
                    return response()->json([
                        'success' => true,
                        'message' => 'Ride request created',
                        'data' => [
                            'id' => $rideRequest->id,
                            'document_id' => $documentId
                        ]
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create ride request',
                    ]);
                }
            });




//            $rideData = [
//                'fields' => [
//                    'customer_id' => ['integerValue' => $user->id],
//                    'customer_location' => [
//                        'mapValue' => [
//                            'fields' => [
//                                'latitude' => ['doubleValue' => $latitude],
//                                'longitude' => ['doubleValue' => $longitude],
//                            ]
//                        ]
//                    ],
//                    'status' => ['stringValue' => StatusEnum::REQUESTED->value],
//                ]
//            ];
//
//            // Use the access token to make an authenticated request to Firestore
//            $response = Http::withToken($tokenString)
//                ->post("https://firestore.googleapis.com/v1/projects/$firsBaseProjectId/databases/(default)/documents/rides", $rideData);
//            $documentName = $response->json()['name'];
//            $documentId = last(explode('/', $documentName));

//            if ($response->successful()) {

//                $rideRequest = $user->myRides()->create([
//                    'street_name' => $streetName,
//                    'price' => $rideDuration->price,
//                    'duration' => $rideDuration->duration,
//                    'ride_duration_id' => $rideDuration->id,
//                    'ride_type' => $rideDuration->stream ? 'Ride & Stream' : 'Ride Only',
//                    'customer_latitude' => $latitude,
//                    'customer_longitude' => $longitude,
//                    'document_id' => $documentId
//                ]);

//                $firestoreUrl = "https://firestore.googleapis.com/v1/projects/$firsBaseProjectId/databases/(default)/documents/rides/{$documentId}?updateMask.fieldPaths=ride_id";
//
//                $updateData = [
//                    "fields" => [
//                        "ride_id" => ["integerValue" => $rideRequest->id],
//                    ]
//                ];
//
//                $response = Http::withToken($tokenString)
//                    ->patch($firestoreUrl, $updateData);
//
//                $this->notificationService->send();

//                return response()->json([
//                    'success' => true,
//                    'message' => 'Ride request created',
//                    'data' => [
//                        'id' => $rideRequest->id,
//                        'document_id' => $documentId
//                    ]
//                ]);
//            } else {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Failed to create ride request',
//                    'error' => $response->body()
//                ], $response->status());
//            }
//        } else {
//            // Handle the case where the access token could not be generated
//            return response()->json([
//                'success' => false,
//                'message' => 'Failed to generate access token',
//                'error' => 'OAuth token generation failed'
//            ], 500);
//        }
    }
}
