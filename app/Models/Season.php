<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'video_trailer',
        'release_date',
        'tv_show_id',
        'status',
        'tags',
        'meta_title',
        'meta_description',
    ];


    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    public function tvShow()
    {
        return $this->hasOne(TvShow::class);
    }
}
