<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoPlay extends Model
{

    protected $fillable = [
        'ip_address',
        'played_seconds'
    ];
}
