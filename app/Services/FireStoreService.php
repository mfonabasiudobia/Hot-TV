<?php

namespace App\Services;

use App\Enums\Ride\StatusEnum;
use App\Models\Ride;
use Kreait\Firebase\Factory;

class FireStoreService
{
    protected $firestore;

    public function __construct()
    {
        // Initialize Firebase Firestore
        $factory = (new Factory)->withServiceAccount(base_path('firebase_credentials.json'));
        $this->firestore = $factory->createFirestore();
    }

    public function createRideDocument(Ride $rideRequest)
    {
        // Firestore instance
        $firestore = $this->firestore->database();

        // Prepare ride data
        $rideData = [
            'customer_id' => $rideRequest->user_id,
            'customer_location' => [
                'latitude' => $rideRequest->latitude,
                'longitude' => $rideRequest->longitude
            ],
            'status' => StatusEnum::REQUESTED->value,
            'ride_id' => $rideRequest->id
        ];

        // Create document in 'rides' collection
        try {
            $newRide = $firestore->collection('rides')->add($rideData);
            dd($newRide);
            // Get document ID from the newly created document
            $documentId = $newRide->id();

            return $documentId;  // Return the document ID

        } catch (\Exception $e) {
            // Handle exception if Firestore operation fails
            throw new \Exception('Firestore error: '.$e->getMessage());
        }
    }
}
