<?php

namespace App\Payment\Enums;

enum StatusEnum:string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
    case FAILED = 'failed';

}
