<?php

namespace Botble\SubscriptionOrder\Enums;

enum OrderStatusEnum:string
{
    case PENDING = 'pending';
    case PAID = 'paid';

    case FAILED = 'failed';

}
