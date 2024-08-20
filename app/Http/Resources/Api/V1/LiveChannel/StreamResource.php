<?php

namespace App\Http\Resources\Api\V1\LiveChannel;

use Illuminate\Http\Resources\Json\JsonResource;

class StreamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

        ];
    }
}
