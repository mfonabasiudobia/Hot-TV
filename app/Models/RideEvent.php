<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideEvent extends Model
{
    use HasFactory;

    protected $table = 'ride_events';

    protected $fillable = [
        'ride_id',
        'user_latitude',
        'user_longitude',
        'customer_longitude',
        'customer_longitude',
        'event_timestamp',
        'event_type'
    ];
}
