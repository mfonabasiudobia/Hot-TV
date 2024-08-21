<?php

namespace App\Enums\Ride;

enum StatusEnum:string
{
    case INITIATED = 'initiated';
    case REQUESTED = 'requested';
    case RIDE_IN_PROGRESS = 'ride-in-progress';
    case RIDE_COMPLETED = 'ride-completed';
    case RIDE_CANCELLED = 'ride-cancelled';

}
