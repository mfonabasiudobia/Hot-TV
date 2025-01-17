<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Botble\ACL\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Botble\Gallery\Models\Gallery;
use Botble\Gallery\Models\GalleryMeta;
use Illuminate\Support\Facades\Storage;

class Ride extends Model
{
    protected $appends = ['views', 'watching', 'stream_thumbnail'];

    protected $fillable = [
        'user_id',
        'driver_id',
        'street_name',
        'price',
        'duration',
        'ride_type',
        'stream',
        'ride_duration_id',
        'customer_latitude',
        'customer_longitude',
        'driver_latitude',
        'customer_longitude',
        'document_id',
        'is_stream_blocked'
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ride_responses(): HasMany
    {
        return $this->hasMany(DriverRideResponse::class, 'ride_id', 'id');
    }


    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }

    public function getWatchingAttribute()
    {
        $views = PedicabStreamView::where('ride_id', $this->attributes['id'])->where('status', 'watching')->count();

        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M'; // For millions
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }

        return number_format($views);
    }

    public function getViewsAttribute()
    {
        $views =  PedicabStreamView::where('ride_id', $this->attributes['id'])->count();

        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M'; // For millions
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }

        return number_format($views);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'ride_id');

    }

    public function getStreamThumbnailAttribute()
    {
        return Storage::disk($this->thumbnail_storage ?? 'public')->url($this->thumbnail);
    }

    public function ride_events()
    {
        return $this->hasMany(RideEvent::class);
    }
}
