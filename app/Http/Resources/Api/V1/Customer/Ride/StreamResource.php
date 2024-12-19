<?php

namespace App\Http\Resources\Api\V1\Customer\Ride;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class StreamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "stream" => $this->stream,
            "duration" => $this->duration,
            "stream_status" => $this->stream_status,
            "token" => $this->stream_channel_token,
            "channel" => $this->stream_channel_name,
        ];
    }
}
