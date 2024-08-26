<?php

namespace Botble\SubscriptionPlan\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Subscription extends BaseModel
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'name',
        'price',
        'subscription_plan_id',
        'stripe_plan_id',
        'paypal_plan_id',
        'status'
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id')->withDefault();
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(SubscriptionFeature::class, 'subscrptions_subscription_features');
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }



    public function orders(): HasMany
    {
        return $this->hasMany(SubscriptionOrder::class);
    }
}
