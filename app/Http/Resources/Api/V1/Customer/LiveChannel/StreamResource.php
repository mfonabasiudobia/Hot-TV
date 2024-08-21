<?php

namespace App\Http\Resources\Api\V1\Customer\LiveChannel;

use Illuminate\Http\Resources\Json\JsonResource;

class StreamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "description" => $this->description,
            "schedule_date" => $this->schedule_date,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "recorded_video" => $this->recorded_video,
            "thumbnail" => $this->thumbnail,
            "stream_type" => $this->stream_type
        ];
    }
}
