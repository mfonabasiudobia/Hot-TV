<?php

namespace App\Http\Controllers\UpgratePlan;

use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function __invoke()
    {
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $oldSubscriptionId = 'I-XXXXXXX'; // Old subscription ID
        $newPlanId = 'P-YYYYYYY'; // New plan ID

// Step 1: Cancel the old subscription
        $provider->cancelSubscription($oldSubscriptionId, 'Upgrading to a new plan');

// Step 2: Create the new subscription
        $newSubscription = $provider->createSubscription([
            'plan_id' => $newPlanId,
            'subscriber' => [
                'name' => [
                    'given_name' => $firstName,
                    'surname' => $lastName,
                ],
                'email_address' => $email,
            ],
            'application_context' => [
                'brand_name' => 'Your Brand Name',
                'locale' => 'en-US',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'SUBSCRIBE_NOW',
                'payment_method' => [
                    'payer_selected' => 'PAYPAL',
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                ],
                'return_url' => route('paypal-checkout'),
                'cancel_url' => route('plan.paypal.payment-cancel'),
            ],
        ]);

        $newSubscriptionId = $newSubscription['id'];

// Save the new subscription
        $user->subscription->paypal_subscription_id = $newSubscriptionId;
        $user->subscription->plan_id = $newPlanId;
        $user->subscription->status = 'active';
        $user->subscription->save();

        return redirect($paypalSubscription['links'][0]['href']);

        Log::info('Subscription upgraded to new plan: ' . $newSubscriptionId);

    }
}
