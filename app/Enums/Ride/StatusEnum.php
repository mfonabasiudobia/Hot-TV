<?php
namespace App\Enums\Ride;

enum StatusEnum:string
{
    case NO_DRIVER_FOUND = "no-driver-found";
    case REQUESTED = 'requested';
    case  ACCEPTED = 'accepted';
    case IN_PROGRESS = 'in-progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case STARTED = 'started';
    case ARRIVED = 'driver-arrived';
}
