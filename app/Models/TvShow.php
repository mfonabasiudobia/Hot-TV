<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class TvShow extends BaseModel
{

    protected $casts = ['tags' => 'array'];

    public function categories(){
        return $this->belongsToMany(ShowCategory::class);
    }

    public function casts(){
        return $this->belongsToMany(Cast::class);
    }

    public function releaseAt(){
        return Carbon::parse($this->release_date)->format('M d, Y');
    }

    public function episodes(){
        return $this->hasMany(Episode::class);
    }

    public function views(){
        return $this->hasMany(TvShowView::class, 'tv_show_id');
    }

    public function watchlists()
    {
        return $this->morphMany(Watchlist::class, 'watchable');
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    public function video(): MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }
}
