<?php

namespace App\Models;

class TvShowView extends BaseModel
{
    protected $fillable = [
        'tv_show_id',
        'user_id',
        'season',
        'episode_id',
        'ip_address'
    ];

    public function tvShow()
    {
        return $this->hasOne(TvShow::class, 'id', 'tv_show_id');
    }

    public function episode()
    {
        return $this->hasOne(Episode::class, 'id', 'episode_id');
    }

}
