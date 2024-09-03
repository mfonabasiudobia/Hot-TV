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
            'trailer' => asset('storage/'. $this->trailer),
            'tags' => $this->tags,
            'release_date' => $this->release_date,
            'is_recommended' => $this->is_recommended == 1,
            'duration' => convert_seconds_to_time($this->episodes()->sum('duration')),
            'episodes' => EpisodeResource::collection($this->episodes),
            'cast' => CastResource::collection($this->whenLoaded('casts')),
            'categories' => ShowCategoryResource::collection($this->whenLoaded('categories'))
        ];
    }
}
