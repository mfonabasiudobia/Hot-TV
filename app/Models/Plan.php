<?php

namespace App\Models;

class Plan extends BaseModel
{
    protected $casts = [
        'price' => 'decimal:2', 
        'can_stream' => 'bool',
        'can_download' => 'bool'
    ];
}
