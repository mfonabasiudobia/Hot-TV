<?php

namespace App\Observers;

use App\Mail\SubscribedSuccessfullyMail;
use App\Mail\SubscriptionRenewalPaymentMail;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionOrder\Enums\RecurringStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Illuminate\Support\Facades\Mail;

class SubscriptionOrderObserver
{

    public function created(SubscriptionOrder $subscriptionOrder) {
        if($subscriptionOrder->recurring_status == RecurringStatusEnum::RENEW->value) {
            $user = $subscriptionOrder->user;
            Mail::to($user->email)->send(new SubscriptionRenewalPaymentMail($user));
        }
    }
    public function updated(SubscriptionOrder $subscriptionOrder)
    {
        if($subscriptionOrder->status == OrderStatusEnum::PAID->value) {
            $user = $subscriptionOrder->user;
            Mail::to($user->email)->send(new SubscribedSuccessfullyMail($user));
        }
    }
}
