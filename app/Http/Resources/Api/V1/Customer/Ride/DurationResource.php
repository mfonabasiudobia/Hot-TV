<?php

namespace App\Http\Resources\Api\V1\Customer\Ride;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class DurationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "duration" => Str::title(str_replace('-', ' ',$this->duration)),
            "price" => $this->price,
            "stream" => $this->stream == 1
        ];
    }
}
