<?php

namespace App\Http\Resources\Api\V1\Customer\TvShow;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail' => asset('storage/' . $this->thumbnail),
            'trailer' => $this->video ? file_path('videos/' . $this->video->id . '_2_3000.m3u8') : asset('storage/'. $this->trailer),
            'tags' => $this->tags,
            'release_date' => $this->release_date,
            'is_recommended' => $this->is_recommended == 1,
            'seasons' => SeasonResource::collection($this->seasons),
            'duration' => convert_seconds_to_time($this->episodes()->sum('duration')),
            'cast' => CastResource::collection($this->whenLoaded('casts')),
            'categories' => ShowCategoryResource::collection($this->whenLoaded('categories'))
        ];
    }
}
