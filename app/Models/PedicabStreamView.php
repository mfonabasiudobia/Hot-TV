<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedicabStreamView extends Model
{
    use HasFactory;

    protected $tabled = "pedicab_stream_views";

    protected $fillable = ['user_id', 'ride_id', 'status', 'ip_address'];
}
