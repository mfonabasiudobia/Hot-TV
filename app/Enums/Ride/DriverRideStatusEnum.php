<?php
namespace App\Enums\Ride;

enum DriverRideStatusEnum:string
{
    case PENDING = 'ride-pending';
    case ACCEPTED = 'ride-accepted';
    case REJECTED = 'ride-rejected';
    case AUTO_REJECTED = 'auto-rejected';
}
