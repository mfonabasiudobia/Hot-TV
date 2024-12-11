<?php

namespace App\Http\Resources\Api\V1\Customer\Ride;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class DurationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "duration" => Str::title(str_replace('-', ' ',$this->duration)),
        ];
    }
}
