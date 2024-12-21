<?php
namespace App\Enums\Ride;

enum DriverRideStatusEnum:string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case AUTO_REJECTED = 'auto-rejected';
}
