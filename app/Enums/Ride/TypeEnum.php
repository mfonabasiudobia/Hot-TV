<?php

namespace App\Enums\Ride;

enum TypeEnum:string
{
    case RIDE_ONLY = 'ride-only';
    case RIDE_WITH_STREAMING = 'ride-with-streaming';

}
