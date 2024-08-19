<?php

namespace App\Http\Resources\Api\V1\Podcast;

use Illuminate\Http\Resources\Json\JsonResource;

class PodcastResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "description" => $this->description,
            "thumbnail" => $this->thumbnail,
            "recorded_video" => $this->recorded_video,
        ];
    }
}
