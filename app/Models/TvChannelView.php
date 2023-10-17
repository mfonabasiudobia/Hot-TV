<?php

namespace App\Models;


class TvChannelView extends BaseModel
{
    public function stream()
    {
        return $this->hasOne(Stream::class, 'id', 'stream_id');
    }
}
