<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{
    protected $dates = [
        'converted_for_downloading_at',
        'converted_for_streaming_at',
    ];

    protected $guarded = [];

    public function getPathAttribute($value)
    {

        return Storage::disk(\App\Enums\VideoDiskEnum::DISK->value)->url(preg_replace('/\.[^.]+$/', '.m3u8', $value));
    }

    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }
}
