<?php

namespace App\Http\Resources\Api\V1\Customer\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class WatchListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->tvShow->slug,
            'title' => $this->tvShow->title,
            'thumbnail' => file_path($this->tvShow->thumbnail),
            'views' => view_count($this->tvShow->views->count()),
            'duration' => convert_seconds_to_time($this->tvShow->episodes()->sum('duration')),
            'category' => $this->tvShow->categories[0]->name
        ];
    }
}
