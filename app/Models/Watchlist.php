<?php

namespace App\Models;

class Watchlist extends BaseModel
{
    public function tvShow()
    {
        return $this->hasOne(TvShow::class, 'id', 'watchable_id');
    }

    public function tvChannel()
    {
        return $this->hasOne(Stream::class, 'id', 'watchable_id');
    }

     public function watchable()
    {
        return $this->morphTo();
    }

}
