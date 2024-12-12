<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Video extends Model
{
    protected $dates = [
        'converted_for_downloading_at',
        'converted_for_streaming_at',
    ];

    protected $guarded = [];

    protected $appends = ['stream_path'];

    /**
     * returns stream path s3
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

    public function streamPath(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::disk(\App\Enums\VideoDiskEnum::DISK->value)->url(preg_replace('/\.[^.]+$/', '.m3u8', $this->attributes['path']))
        );
    }

    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }
}
