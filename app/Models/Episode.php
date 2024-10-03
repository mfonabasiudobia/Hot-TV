<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Episode extends BaseModel
{
    public function releaseAt(){
        return Carbon::parse($this->release_date)->format('M d, Y');
    }

    public function views(){
        return $this->hasMany(TvShowView::class, 'episode_id');
    }

    public function tvShow()
    {
        return $this->hasOne(TvShow::class, 'id', 'tv_show_id');
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function video(): MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }
}
