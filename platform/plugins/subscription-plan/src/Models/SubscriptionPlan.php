<?php

namespace Botble\SubscriptionPlan\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SubscriptionPlan extends BaseModel
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'status',
        'trail',
        'interval',
        'trail_period_stripe',
        'trail_period_paypal'

    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'trail' => 'boolean'
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
