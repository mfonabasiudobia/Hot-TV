<?php

namespace Botble\SubscriptionPlan\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Botble\ACL\Models\User;

class SubscriptionOrder extends BaseModel
{
    protected $table = 'subscription_orders';

    protected $fillable = [
        'amount',
        'user_id',
        'subscription_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'payment_method_type',
        'session_id',
        'sub_total',
        'status',
        'current_subscription'
    ];

    protected $casts = [
        //'status' => BaseStatusEnum::class,
        //'name' => SafeContent::class,
    ];

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }

    protected function taxAmount(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }

    protected function discountAmount(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }

    protected function subTotal(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value / 100,
            set: fn (mixed $value) => $value * 100
        );
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
