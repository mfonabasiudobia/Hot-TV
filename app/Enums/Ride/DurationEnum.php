<?php

namespace App\Enums\Ride;

enum DurationEnum:string
{
    case FIVE_MINUTES = 'five-minutes';
    case TEM_MINUTES = 'ten-minutes';
    case TWENTY_MINUTES = 'twenty_minutes';
    case SIXTY_MINUTES = 'sixty_minutes';
}
