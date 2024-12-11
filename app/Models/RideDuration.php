<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class RideDuration extends Model
{

    protected $fillable = [
        'duration',
        'price',
        'stream'
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }

    public function getPriceWithStreamAttribute()
    {
        return $this->where('duration', $this->duration)
            ->where('stream', true)
            ->value('price');
    }

    // Accessor to get price without stream
    public function getPriceWithoutStreamAttribute()
    {
        return $this->where('duration', $this->duration)
            ->where('stream', false)
            ->value('price');
    }
}
