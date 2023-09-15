<?php

namespace App\Models;

class ShowCategory extends BaseModel
{
        public function categories(){
            return $this->belongsToMany(TvShow::class);
        }
}
