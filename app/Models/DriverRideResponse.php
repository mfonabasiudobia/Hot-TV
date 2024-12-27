<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRideResponse extends Model
{
    use HasFactory;

    protected $fillable = ['ride_id', 'driver_id', 'status'];
    protected $table = "ride_driver_responses";

    public function ride()
    {
        return $this->belongsTo(Ride::class,"ride_id");
    }
}
