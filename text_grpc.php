<?php
require 'vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

// Initialize Firestore client
$firestore = new FirestoreClient([
    'projectId' => 'hot-tv-a57ea'
]);

// Test Firestore communication
try {

    $documentRef = $firestore->collection('ride')->document('testDoc');
    $documentRef->set([
        'message' => 'Hello World!'
    ]);
    echo "Document written successfully!";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
