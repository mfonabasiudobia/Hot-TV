<?php

namespace App\Http\Resources\Api\V1\Customer\Ride;

use Botble\Api\Http\Resources\UserResource;
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
            "street_name" => $this->street_name,
            "token" => $this->stream_channel_token,
            "channel" => $this->stream_channel_name,
            "customer"    =>  new UserResource($this->customer),
            "views" => $this->views,
            "watching" =>   $this->watching
        ];
    }
}
