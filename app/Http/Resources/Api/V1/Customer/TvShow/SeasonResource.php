<?php

namespace App\Http\Resources\Api\V1\Customer\TvShow;

use Illuminate\Http\Resources\Json\JsonResource;

class SeasonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "slug" =>  $this->slug,
            "description" =>  $this->description,
            'season' => $this->season_number,
            "thumbnail" =>  asset('storage/'. $this->thumbnail),
            "recorded_video" =>  asset('storage/'. $this->recorded_video),
            "release_date" =>  $this->release_date,
            'episodes' => EpisodeResource::collection($this->episodes),
        ];
    }
}
