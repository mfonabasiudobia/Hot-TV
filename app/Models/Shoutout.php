<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Shoutout extends BaseModel
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'meta_title',
        'media_url',
        'status',
        'media_type',
        'meta_description'
    ];
    public function views(){
        return $this->hasMany(ShoutoutView::class, 'shoutout_id');
    }

    public function video(): Morphone
    {
        return $this->morphOne(Video::class, 'videoable');
    }
}
