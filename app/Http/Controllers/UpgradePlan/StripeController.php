<?php

namespace App\Http\Controllers\UpgradePlan;

use App\Http\Controllers\Controller;
use Botble\SubscriptionPlan\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Stripe\Subscription as SubscriptionStripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function __invoke(Subscription $subscription)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        $order = auth()->user()->subscription;
        $localSubscriptionId = $subscription->id;

        $subscriptionId = $order->stripe_subscription_id;
        $newStripePriceId = $subscription->stripe_plan_id;
        $stripeSubscription = SubscriptionStripe::retrieve($subscriptionId);

        if ($stripeSubscription->status === 'incomplete') {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'customer' => $stripeSubscription->customer,
                'line_items' => [['price' => $subscription->stripe_plan_id, 'quantity' => 1,],],
                'success_url' => url('plan/stripe/payment-verification/{CHECKOUT_SESSION_ID}'),
                // 'cancel_url' => route('subscription.cancel')
            ]);

            $order->subscription_id = $subscription->id;
            $order->session_id = $session->id;
            $order->save();

            return redirect($session->url);

            // return redirect()->back()->with('success', 'Cannot update a subscription in \'incomplete\' status.');
        }

        $updatedSubscription = SubscriptionStripe::update($stripeSubscription->id, [
            'items' => [
                [
                    'id' => $stripeSubscription->items->data[0]->id,
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

        if ($updatedSubscription->status == 'active') {
            $order->stripe_subscription_id = $updatedSubscription->id;
            $order->subscription_id = $localSubscriptionId;
            $order->save();

            return redirect()->back()->with('success', 'Subscription Updated Successfully');
        }

        Log::info('Subscription upgraded: ' . $updatedSubscription->id);
    }
}
