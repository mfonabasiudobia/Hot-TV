<?php

namespace Botble\SubscriptionPlan\Enums;

enum SubscriptionStatus:string
{
    case DRAFT = 'draft';
    case PAUSED = 'paused';
    case PUBLISHED = 'published';
   
}