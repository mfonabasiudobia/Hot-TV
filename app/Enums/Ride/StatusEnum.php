<?php
namespace App\Enums\Ride;

enum StatusEnum:string
{
    case REQUESTED = 'requested';
    case  ACCEPTED = 'accepted';
    case IN_PROGRESS = 'in-progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
