<?php

namespace App\Models;

class Cast extends BaseModel
{
    public function tvShow(){
        return $this->belongsTo(TvShow::class);
    }
    
    public function tvshows(){
        return $this->belongsToMany(TvShow::class);
    }
}
