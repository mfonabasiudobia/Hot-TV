<?php

namespace App\Models;
use Carbon\Carbon;

class Episode extends BaseModel
{
    public function releaseAt(){
        return Carbon::parse($this->release_date)->format('M d, Y');
    }

    public function views(){
        return $this->hasMany(TvShowView::class, 'episode_id');
    }
}
