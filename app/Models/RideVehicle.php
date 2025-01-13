<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideVehicle extends Model
{
    use HasFactory;

    protected $fillable = ['driver_id', 'vehicle_reg_number', 'vehicle_make', 'vehicle_model', 'vehicle_year', 'vehicle_color'];
}
