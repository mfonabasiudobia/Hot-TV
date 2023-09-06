<?php

namespace Botble\Stream\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\StreamRepository;

class AvailableTime implements Rule
{
    public $scheduleDate;
    
    public function __construct($scheduleDate){
        $this->scheduleDate = $scheduleDate;
    }
    
    public function passes($attribute, $value)
    {
        $streamRanges = StreamRepository::getTimeRangeAlreadyScheduled($this->scheduleDate);

        // return StreamRepository::isTimeInRange($value, $streamRanges) ? false : true;

        return true;
    }

    public function message()
    {
        return 'The :attribute is not available';
    }

}
