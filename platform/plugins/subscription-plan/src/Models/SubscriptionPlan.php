<?php

namespace Botble\SubscriptionPlan\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends BaseModel
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'status',
        'trail',
        'trail_period'

    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
