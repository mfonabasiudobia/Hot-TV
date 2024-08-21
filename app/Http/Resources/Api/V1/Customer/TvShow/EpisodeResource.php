<?php

namespace App\Http\Resources\Api\V1\Customer\TvShow;

use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" =>  $this->id,
            "title" =>  $this->title,
            "slug" =>  $this->slug,
            "description" =>  $this->description,
            "season_number" =>  $this->season_number,
            "episode_number" =>  $this->episode_number,
            "duration" =>  $this->duration,
            "thumbnail" =>  $this->thumbnail,
            "recorded_video" =>  $this->recorded_video,
            "release_date" =>  $this->release_date,
        ];
    }
}
