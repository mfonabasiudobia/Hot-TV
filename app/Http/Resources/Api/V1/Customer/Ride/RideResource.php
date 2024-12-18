<?php

namespace App\Http\Resources\Api\V1\Customer\Ride;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RideResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "driver_id" => $this->driver_id,
            "stream" => $this->stream,
            "ride_type" => $this->ride_type,
            "price" => $this->price,
            "duration" => $this->duration,
            "street_name" => $this->street_name,
            "customer_latitude" => $this->customer_latitude,
            "customer_longitude" => $this->customer_longitude,
            "status" => $this->status,
        ];
    }
}
