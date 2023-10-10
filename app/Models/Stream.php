<?php

namespace App\Models;

class Stream extends BaseModel
{

    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    // Accessor for start_time
    public function getStartTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i:s');
    }

    // Accessor for end_time
    public function getEndTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i:s');
    }


    
}
