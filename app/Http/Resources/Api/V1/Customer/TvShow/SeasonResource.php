<?php

namespace App\Http\Resources\Api\V1\Customer\TvShow;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            // "recorded_video" =>  $this->video ? Storage::disk('public')->url('videos/' . $this->video->id . '._2_3000.m3u8') : asset('storage/'. $this->recorded_video),
            "release_date" =>  $this->release_date,
            'episodes' => EpisodeResource::collection($this->episodes),
            "video" => $this->video
        ];
    }
}
