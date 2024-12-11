<?php

namespace App\Enums\User;

enum StatusEnum:string
{
    case LOCKED = 'locked';
    case ACTIVATED = 'activated';
}
