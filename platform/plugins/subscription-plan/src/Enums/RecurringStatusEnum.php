<?php

namespace Botble\SubscriptionOrder\Enums;

enum RecurringStatusEnum:string
{
    case NEW = 'new';
    case RENEW = 'renew';
}
