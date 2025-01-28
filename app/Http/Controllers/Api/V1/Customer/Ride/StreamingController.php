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

        if($status) $streams->where('stream_status', $status);

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
            $uid =  $isPublisher ? $request->user()->id : 1;

            $token = $this->createToken($channelName, $isPublisher, $uid);

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

            $token = $this->createToken($ride->stream_channel_name, false, $ride->user_id);

            $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/resourceid/{$resourceId['resourceId']}/mode/mix/start";

            $data = [
                'cname' => 'stream-224-754', // $ride->stream_channel_name,
                'uid' => '224', // "{$ride->user_id}",
                'clientRequest' => [
                    'token' => $token,
                    'recordingConfig' => [
                        "maxIdleTime"=> 120,
                        "streamTypes"=> 2,
                        // "audioProfile"=> 1,
                        "channelType"=> 1,
                        // "videoStreamType"=> 0,
                        "transcodingConfig"=> [
                            "height"=> 640,
                            "width"=> 360,
                            "bitrate"=> 1000,
                            "fps"=> 15,
                            "mixedVideoLayout"=> 1,
                        ],
                        "subscribeVideoUids" => [
                            "{$ride->user_id}"
                        ],
                        "subscribeAudioUids" => [
                            "{$ride->user_id}"
                        ],
                        "subscribeUidGroup" => 0
                    ],
                    'storageConfig' => [
                        'vendor' => 1,
                        'region' => 21,
                        'bucket' => env('AWS_BUCKET'),
                        'accessKey' => env('AWS_ACCESS_KEY_ID'),
                        'secretKey' => env('AWS_SECRET_ACCESS_KEY'),
                        'fileNamePrefix' => ['recordings', 'ride' . $ride->id],
                    ],
                ],
            ];
            // dd($data);
            $response = $this->sendAgoraRequest($url, $data);

            \Log::info('agora start response', $response);

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
            $sid = $request->sid;
            $resourceId = $request->resource_id;

            // $channelName = $ride->stream_channel_name;
            $channelName = 'stream-224-789';

            $sid = $request->sid;

            // Agora Cloud Recording Stop API URL
            $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/resourceid/{$resourceId}/sid/{$sid}/mode/mix/stop";
            // dd($url);
            $data = [
                'cname' => $channelName,
                'uid' => '224',
                'clientRequest' => new \stdClass()
            ];
            // dd($data);
            $response = $this->sendAgoraRequest($url, $data);

            $ride->stream_status = 'completed';
            $ride->save();

            return response()->json([
                'success' => true,
                'message' => 'recording details',
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

    public function recordingDetails(Ride $ride, Request $request)
    {
        try {
            $sid = $request->sid;
            $resourceId = $request->resource_id;

            // Agora Cloud Recording Stop API URL
            $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/resourceid/{$resourceId}/sid/{$sid}/mode/mix/query";
            // dd($url);
            $response = $this->sendgAgoraGetRequest($url);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STREAM_RECORDING_STOPPED->value,
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
        $ride->thumbnail_storage = env('FILESYSTEM_DISK');
        $ride->save();

        $path = Storage::disk(env('FILESYSTEM_DISK'))->url($path);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::STREAM_THUMBNAIL_UPLOAD->value,
            "result"   =>   $path
        ]);
    }

    public function getResourceId($ride)
    {
        $url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording/acquire";
        $request = new \stdClass();
        $request->resourceExpiredHour = 24;
        $request->scene = 0;

        $data = [
            'cname' => 'stream-224-789      ', // $ride->stream_channel_name,
            'uid' => '224' ,// $ride->user_id, // "0",
            'clientRequest' => $request,
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

    private function sendgAgoraGetRequest($url)
    {
        $key = env('AGORA_CLIENT_KEY');
        $secret = env('AGORA_CLIENT_SECRET');
        $credentials = $key . ":" . $secret;

        $authKey = "Basic " . base64_encode($credentials);
        $response = Http::withHeaders([
            'Authorization' => $authKey,
            'Content-Type' => 'application/json'
        ])->get($url);

        return $response->json();
    }

    private function createToken($channelName, $isPublisher, $uid)
    {
        $appCertificate = env('AGORA_APP_CERTIFICATE');

        $role = $isPublisher ? RtcTokenBuilder::RolePublisher : RtcTokenBuilder::RoleSubscriber;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpireTime = $currentTimestamp + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUid($this->appId, $appCertificate, $channelName, $uid, $role, $privilegeExpireTime);

        return $token;
    }
}
