<?php

namespace App\Models;

class Podcast extends BaseModel
{
    public function views(){
        return $this->hasMany(PodcastView::class, 'podcast_id');
    }
}
