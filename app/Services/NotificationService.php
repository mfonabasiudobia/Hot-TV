<?php

namespace App\Services;

use Google_Client;
use http\Client;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationService
{
    public function send(): void
    {

        $serviceAccountKeyFile = base_path('firebase_credentials.json');

        $firebaseCredentials = (new Factory)->withServiceAccount($serviceAccountKeyFile);

        $messaging = $firebaseCredentials->createMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
              'title' => 'First notification from Hot-tv',
              'body' => 'This is first notification from Hot-tv'
            ],
            'topic' => 'global',
            //'token' => $user->token
        ]);

        $messaging->send($message);





//        $firsBaseProjectId = config('services.firebase.project_id');
//
//        $response = Http::post("https://fcm.googleapis.com/v1/projects/$firsBaseProjectId/messages:send", [
//            'headers' => [
//                'Authorization' => 'Bearer ' . $this->getAccessToken(),
//                'Content-Type' => 'application/json',
//            ],
//            'json' => [
//                'message' => [
//                    'token' => $message['to'],
//                    'notification' => $message['notification'],
//                    'data' => $message['data'],
//                ],
//            ],
//        ]);
//
//        return $response;
    }

}
