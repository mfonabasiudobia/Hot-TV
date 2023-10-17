<?php

namespace App\Models;

class TvShowView extends BaseModel
{
    public function tvShow()
    {
        return $this->hasOne(TvShow::class, 'id', 'tv_show_id');
    }

    public function episode()
    {
        return $this->hasOne(Episode::class, 'id', 'episode_id');
    }

}
