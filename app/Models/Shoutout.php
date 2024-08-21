<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(PodcastView::class, 'podcast_id');
    }
}
