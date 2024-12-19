<?php

namespace App\Http\Controllers\Webhook\Paypal;

use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use Botble\ACL\Models\User;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionOrder\Enums\RecurringStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Subscription;

class EventController extends Controller
{
    public function __invoke(Request $request)
    {
        $eventType = $request->input('event_type');
        \Log::info('stripe event'. $eventType);
        switch ($eventType) {
            case 'PAYMENT.SALE.COMPLETED':
                // Payment succeeded
                $this->handlePaymentCompleted($request);
                break;

            case 'PAYMENT.SALE.DENIED':
                // Payment failed
                $this->handlePaymentFailed($request);
                break;

            case 'BILLING.SUBSCRIPTION.CREATED':
                // Subscription created
                $this->handleSubscriptionCreated($request);
                break;
            case 'BILLING.SUBSCRIPTION.ACTIVATED':
                $this->handleSubscriptionActivated($request);
                break;

            case 'BILLING.SUBSCRIPTION.UPDATED':
                // Subscription updated
                $this->handleSubscriptionUpdated($request);
                break;

            case 'BILLING.SUBSCRIPTION.CANCELLED':
                // Subscription cancelled
                $this->handleSubscriptionCancelled($request);
                break;

            case 'BILLING.SUBSCRIPTION.EXPIRED':
                // Subscription expired
                $this->handleSubscriptionExpired($request);
                break;

            default:
                Log::warning('Unhandled PayPal Webhook Event: ' . $eventType);
                break;
        }

    }

    private function handlePaymentCompleted(Request $request)
    {
        dd($request);
    }

    private function handlePaymentFailed(Request $request)
    {
        dd($request);
    }

    private function handleSubscriptionCreated(Request $request)
    {
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $resource = $request->input('resource');
        $subscriptionId = $resource['id'];
        $response = $provider->showSubscriptionDetails($subscriptionId);

        $subscriberEmail = $resource['subscriber']['email_address'];

        $user = User::where('email', $subscriberEmail)->first();
        $subscription = $user->subscription;
        $subscription->paypal_subscription_id = $subscriptionId;

        if (!empty($response) && isset($response['billing_info']['next_billing_time'])) {
            $nextBillingDate = date('Y-m-d H:i:s', $response['billing_info']['next_billing_time']);
        }

        $subscription->next_billing_date = $nextBillingDate;
        $subscription->save();
        Log::info(json_encode('New Subscription created from paypal: ' . $subscriptionId));

    }

    private function handleSubscriptionActivated(Request $request)
    {
        $paypalSubscription = $request->input('resource');
        $subscriptionId = $paypalSubscription['id'];
        $billingCurrencyCode = $paypalSubscription['billing_info']['outstanding_balance']['currency_code'];
        $billingAmount = $paypalSubscription['billing_info']['outstanding_balance']['value'];
        $cycleExecution = $paypalSubscription['billing_info']['cycle_executions'];

        $isInTrial = false;
        $isEnteringRegular = false;

        foreach($cycleExecution as $cycle) {
            if($cycle['tenure_type'] == 'TRIAL' && $cycle['cycles_completed'] == 1) {
                $isInTrial = true;

            }  else if($cycle['tenure_type'] == 'REGULAR' && $cycle['cycles_completed'] == 1)  {
                $isEnteringRegular = true;
            }

        }


        $status = $paypalSubscription['status'];

        $subscriptionOrder = SubscriptionOrder::where('paypal_subscription_id', $subscriptionId)
            ->where('current_subscription', true)
            ->first();

        if($isInTrial && !$isEnteringRegular){

            if($subscriptionOrder && $subscriptionOrder->status != OrderStatusEnum::PAID->value) {
                $subscriptionOrder->amount = $billingAmount;
                $subscriptionOrder->sub_total = $billingAmount;
                if($subscriptionOrder->status == OrderStatusEnum::PENDING->value) {
                    $subscriptionOrder->status = OrderStatusEnum::PAID->value;
                }
                $subscriptionOrder->save();
                $user = $subscriptionOrder->user;
                $user->status = StatusEnum::ACTIVATED->value;
                $user->save();

            }

        } elseif($isEnteringRegular) {
            $subscriptionOrder->current_subscription = 0;
            if($subscriptionOrder->status == OrderStatusEnum::TRAIL->value) {
                $subscriptionOrder->trail_ended_at = now();
            }

            $subscriptionOrder->save();
            $user = $subscriptionOrder->user;

            $newSubscriptionPayment = SubscriptionOrder::create([
                'amount' => $billingAmount,
                'subscription_id' => $subscriptionId,
                'user_id' => $user->id,
                'payment_method_type' => 'paypal',
                'session_id' => $subscriptionOrder->session_id,
                'sub_total' => $billingAmount,
                'paypal_subscription_id' => $subscriptionOrder->paypal_subscription_id,
                'status' => OrderStatusEnum::PAID->value,
                'recurring_status' => RecurringStatusEnum::RENEW->value
            ]);
        }

        Log::info(json_encode('New Subscription activated from paypal: ' . $subscriptionId));
    }
    private function handleSubscriptionUpdated(Request $request)
    {
        dd($request);
    }

    private function handleSubscriptionCancelled(Request $request)
    {
        $resource = $request->input('resource');
        $subscriptionId = $resource['id'];


        $subscription = SubscriptionOrder::where('stripe_subscription_id', $subscriptionId)
            ->where('current_subscription', true)
            ->first();
        $user = $subscription->user;
        $user->status = StatusEnum::LOCKED->value;
        $user->save();
        Log::info(json_encode('New Subscription cancelled from paypal: ' . $subscriptionId));
    }

    private function handleSubscriptionExpired(Request $request)
    {
        $resource = $request->input('resource');
        $subscriptionId = $resource['id'];

        $subscription = SubscriptionOrder::where('paypal_subscription_id', $subscriptionId)
            ->where('current_subscription', true)
            ->first();
        $user = $subscription->user;
        $user->status = StatusEnum::LOCKED->value;
        $user->save();
        Log::info(json_encode('New Subscription cancelled from paypal:' . $subscriptionId));
    }
}
