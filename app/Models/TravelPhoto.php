<?php

namespace App\Models;

class TravelPhoto extends BaseModel
{
    protected $casts = [
        'images' => 'array'
    ];
}
