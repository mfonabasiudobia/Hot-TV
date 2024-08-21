<?php

namespace App\Enums\Ride;

enum PaymentStatusEnum:string
{
    case PAYMENT_PENDING = 'payment_pending';
    case PAYMENT_COMPLETED = 'payment_completed';
}
