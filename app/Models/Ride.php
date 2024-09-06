<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Botble\ACL\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ride extends Model
{
    protected $fillable = [
        'user_id',
        'driver_id',
        'street_name',
        'price',
        'duration',
        'ride_type',
        'ride_duration_id',
        'customer_latitude',
        'customer_longitude',
        'driver_latitude',
        'customer_longitude',
        'document_id'
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }
}
