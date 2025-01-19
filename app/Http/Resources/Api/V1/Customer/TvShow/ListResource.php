<?php

namespace App\Http\Resources\Api\V1\Customer\TvShow;

use App\Models\Watchlist;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            // 'trailer' => $this->video ? Storage::disk('video_disk')->url( Str::slug($this->title) . '/' . $this->video->uuid . '_2_3000.m3u8')  : asset('storage/'. $this->trailer),
            'tags' => $this->tags,
            'release_date' => $this->release_date,
            'is_recommended' => $this->is_recommended == 1,
            'seasons' => SeasonResource::collection($this->seasons),
            'duration' => convert_seconds_to_time($this->episodes()->sum('duration')),
            'cast' => CastResource::collection($this->whenLoaded('casts')),
            'categories' => ShowCategoryResource::collection($this->whenLoaded('categories')),
            "trailer" => $this->video,
            "added_to_watchlist" => !!Watchlist::where('user_id', auth()->id())->where('watchable_id', $this->id)->where('watchable_type', 'App\Models\TvShow')->first()
        ];
    }
}
