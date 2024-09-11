<?php

namespace App\Http\Resources\Api\V1\Customer\Podcast;

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
            "thumbnail" => asset('storage/' . $this->thumbnail),
            "recorded_video" => asset('storage/' .$this->recorded_video),
        ];
    }
}
