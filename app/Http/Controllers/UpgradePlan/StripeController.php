<?php

namespace App\Http\Controllers\UpgradePlan;

use App\Http\Controllers\Controller;
use Botble\SubscriptionPlan\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Stripe\Subscription as SubscriptionStripe;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function __invoke(Subscription $subscription)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        $order = $subscription->order;
        $subscriptionId = $order->stripe_subscription_id;
        $newStripePriceId = $subscription->price;
        $subscription = SubscriptionStripe::retrieve($subscriptionId);

        $updatedSubscription = SubscriptionStripe::update($subscription->id, [
            'items' => [
                [
                    'id' => $subscription->items->data[0]->id,
                    'price' => $newStripePriceId,
                ],
            ],
            'proration_behavior' => 'create_prorations',
            'billing_cycle_anchor' => 'now',
        ]);

        // Check if additional payment is required
        if ($updatedSubscription->status == 'incomplete') {
            // Redirect the user to the hosted invoice page or checkout to pay for the proration amount
            return redirect($updatedSubscription->latest_invoice->hosted_invoice_url);
        }

        Log::info('Subscription upgraded: ' . $updatedSubscription->id);
    }
}
