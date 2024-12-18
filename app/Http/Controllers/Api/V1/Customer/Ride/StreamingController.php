<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;
use App\Services\AgoraDynamicKey\RtcTokenBuilder\RtcTokenBuilder;
use Illuminate\Support\Facades\Http;
use App\Enums\VideoDiskEnum;
use Illuminate\Support\Str;

class StreamingController extends Controller
{
    private $appId;
    public function __construct()
    {
        $this->appId = env('AGORA_APP_ID');
    }
    public function store(Ride $ride, Request $request)
    {
        try {

            $channelName = "stream-{$ride->customer->id}-{$ride->id}";
            $appCertificate = env('AGORA_APP_CERTIFICATE');
            $uid = $ride->user_id; // ride customer id
            $role = RtcTokenBuilder::RolePublisher;
            $expireTimeInSeconds = 3600;
            $currentTimestamp = now()->getTimestamp();
            $privilegeExpireTime = $currentTimestamp + $expireTimeInSeconds;

            $token = RtcTokenBuilder::buildTokenWithUid($this->appId, $appCertificate, $channelName, $uid, $role, $privilegeExpireTime);

            $ride->stream_channel_name = $channelName;
            $ride->is_stream_blocked = false;
            $ride->stream_channel_token = $token;
            $ride->save();

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_CREATED->value,
                'data' => [
                    'token' =>  $token,
                    'channelName' => $channelName,
                    'app_id' => $this->appId, // TODO: r&d will this not be security risk to expose api in api endpoint
                ]
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }

    public function start(Ride $ride, Request $request)
    {
        try{
            $resourceId = $this->getResourceId($ride);
            if(! isset($resourceId['resourceId'])){
                throw new \Exception('Resource Id Not found');
            }

            $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/resourceid/{$resourceId['resourceId']}/mode/mix/start";

            $data = [
                'cname' => 'stream-87-170',
                'uid' => "0",
                'clientRequest' => [
                    'recordingConfig' => [
                        'maxIdleTime' => 30,
                        'streamTypes' => 2,
                        'channelType' => 1,
                        'videoStreamType' => 0,
                        'transcodingConfig' => [
                            'height' => 720,
                            'width' => 1280,
                            'bitrate' => 1000,
                            'fps' => 15,
                        ],
                    ],
                    'storageConfig' => [
                        'vendor' => 1,
                        'region' => 0,
                        'bucket' => VideoDiskEnum::DISK->value,
                        'accessKey' => env('AWS_ACCESS_KEY_ID'),
                        'secretKey' => env('AWS_SECRET_ACCESS_KEY'),
                        'fileNamePrefix' => ['recordings'],
                    ],
                ],
            ];

            $response = $this->sendAgoraRequest($url, $data);

            $ride->stream_status = 'streaming';
            $ride->save();

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_RECORDING_STARTED->value,
                'data' => $response
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }

    public function stop(Ride $ride, Request $request)
    {
        try {
            $resourceId = $this->getResourceId($ride->stream_channel_name);
            $token = $request->input('token');
            $channelName = $ride->stream_channel_name;
            $uid = "0";

            // Agora Cloud Recording Stop API URL
            $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/resourceid/{$resourceId}/mode/mix/stop";

            $response = Http::post($url, [
                'cname' => $channelName,
                'uid' => "0",
                'clientRequest' => []
            ]);

            $ride->stream_status = 'completed';
            $ride->save();

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_RECORDING_STOPPED->value,
                'data' => $response->json()
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }


    public function show(Ride $ride)
    {
        try{
            $data = [];
            $data['stream_channel_name'] = $ride->stream_channel_name;
            $data['is_stream_blocked'] = $ride->is_stream_blocked;

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_RECORDING_STARTED->value,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }

    public function getResourceId($ride)
    {
        $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/acquire";
        $data = [
            'cname' => 'stream-87-170', // $ride->stream_channel_name,
            'uid' => "0",
            'clientRequest' => new \stdClass(),
        ];

        return $this->sendAgoraRequest($url, $data);
    }

    private function sendAgoraRequest($url, $data)
    {
        $key = env('AGORA_CLIENT_KEY');
        $secret = env('AGORA_CLIENT_SECRET');
        $credentials = $key . ":" . $secret;

        $authKey = "basic " . base64_encode($credentials);
        $response = Http::withHeaders([
            'Authorization' => $authKey,
            'Content-Type' => 'application/json'
        ])->post($url, $data);

        return $response->json();
    }
}
