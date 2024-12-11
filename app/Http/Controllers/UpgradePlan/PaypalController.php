<?php

namespace App\Http\Controllers\UpgradePlan;

use App\Http\Controllers\Controller;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function __invoke(Subscription $subscription, SubscriptionPlan $subscriptionPlan)
    {
        $user = Auth::user();
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $oldSubscriptionId = auth()->user()->subscription->paypal_subscription_id; // Old subscription ID
        $newPlanId = $subscription->paypal_plan_id; // New plan ID

        // Step 1: Cancel the old subscription
        $provider->cancelSubscription($oldSubscriptionId, 'Upgrading to a new plan');

        // Step 2: Create the new subscription

        $newSubscription = $provider->createSubscription([
            'plan_id' => $newPlanId,
            'subscriber' => [
                'name' => [
                    'given_name' => $user->first_name,
                    'surname' => $user->last_name,
                ],
                'email_address' => $user->email,
            ],
            'application_context' => [
                'brand_name' => 'Hot TV',
                'locale' => 'en-US',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'SUBSCRIBE_NOW',
                'payment_method' => [
                    'payer_selected' => 'PAYPAL',
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                ],
                // 'return_url' => route('paypal-checkout'),
                'return_url' => route('plan.paypal.payment-verification.success'),
                'cancel_url' => route('plan.paypal.payment-cancel'),
            ],
        ]);

        $newSubscriptionId = $newSubscription['id'];

        // Save the new subscription
        $user->subscription->paypal_subscription_id = $newSubscriptionId;
        // $user->subscription->plan_id = $newPlanId;
        $user->subscription->status = 'active';
        $user->subscription->save();

        Log::info('Subscription upgraded to new plan: ' . $newSubscriptionId);
        return redirect($newSubscription['links'][0]['href']);

    }
}
