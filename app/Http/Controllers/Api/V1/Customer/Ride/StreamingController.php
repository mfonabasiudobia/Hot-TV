<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;
use App\Services\AgoraDynamicKey\RtcTokenBuilder\RtcTokenBuilder;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Api\V1\Customer\Ride\StreamResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StreamingController extends Controller
{
    private $appId;
    public function __construct()
    {
        $this->appId = env('AGORA_APP_ID');
    }

    public function index(Request $request)
    {
        $status = $request->status;

        $streams = Ride::with(['customer']);

        if($status) $streams->where('status', $status);

        $streams = $streams->paginate(10);

        $streams = StreamResource::collection($streams);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::STREAM_LIST->value,
            'data' => [
                'streams' => $streams
            ]
        ]);
    }

    public function store(Ride $ride, Request $request)
    {
        try {
            $isPublisher = $ride->user_id == $request->user()->id;

            $channelName = "stream-{$ride->customer->id}-{$ride->id}";
            $appCertificate = env('AGORA_APP_CERTIFICATE');
            $uid =  $isPublisher ? $request->user()->id : 0; // ride customer id
            $role = $isPublisher ? RtcTokenBuilder::RolePublisher : RtcTokenBuilder::RoleSubscriber;
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
                'cname' => $ride->stream_channel_name,
                'uid' => $ride->user_id,
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
                        'region' => 11,
                        'bucket' => env('AWS_BUCKET'),
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
            $channelName = $ride->stream_channel_name;

            // Agora Cloud Recording Stop API URL
            $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/resourceid/{$resourceId}/mode/mix/stop";

            $response = Http::post($url, [
                'cname' => $channelName,
                'uid' => $request->user()->id,
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

    public function uploadThumbnail(Ride $ride, Request $request)
    {
        $uuid = Str::uuid();
        $thumbnail = $request->file('image');
        $filename = $uuid . "." . $thumbnail->getClientOriginalName();

        $path = $thumbnail->storeAs('pedicab', $filename, env('FILESYSTEM_DISK'));

        $ride->thumbnail = $path;
        $ride->thumbnail_storage = 's3';
        $ride->save();

        $path = Storage::disk('s3')->url($path);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::STREAM_THUMBNAIL_UPLOAD->value,
            "result"   =>   $path
        ]);
    }

    public function getResourceId($ride)
    {
        $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/acquire";
        $data = [
            'cname' => $ride->stream_channel_name,
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

        $authKey = "Basic " . base64_encode($credentials);
        $response = Http::withHeaders([
            'Authorization' => $authKey,
            'Content-Type' => 'application/json'
        ])->post($url, $data);

        return $response->json();
    }
}
