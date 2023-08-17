<?php

namespace App\Models;

class Stream extends BaseModel
{

    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Accessor for start_time
    public function getStartTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i');
    }

    // Accessor for end_time
    public function getEndTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i');
    }


    
}
