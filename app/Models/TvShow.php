<?php

namespace App\Models;

class TvShow extends BaseModel
{
    public function categories(){
        return $this->belongsToMany(ShowCategory::class);
    }
}
