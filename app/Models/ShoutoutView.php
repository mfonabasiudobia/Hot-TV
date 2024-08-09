<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoutoutView extends Model
{

    protected $fillable = [
        'user_id',
        'shoutout_id',
        'ip_address'
    ];
}
