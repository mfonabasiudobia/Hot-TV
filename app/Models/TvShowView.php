<?php

namespace App\Models;

class TvShowView extends BaseModel
{
    public function tvShow()
    {
        return $this->hasOne(TvShow::class, 'id', 'tv_show_id');
    }
}
