<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;

class Podcast extends BaseModel
{
    public function views(){
        return $this->hasMany(PodcastView::class, 'podcast_id');
    }

    public function video(): MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }
}
