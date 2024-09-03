<?php

namespace App\Http\Controllers\Webhook\Paypal;

use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use Botble\ACL\Models\User;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
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


        $resource = $request->input('resource');
        $subscriptionId = $resource['id'];
        $subscriberEmail = $resource['subscriber']['email_address'];

        $user = User::where('email', $subscriberEmail)->first();
        $subscription = $user->subscription;
        $subscription->paypal_subscription_id = $subscriptionId;
        $subscription->save();
        Log::info(json_encode('New Subscription created from paypal: ' . $subscriptionId));

    }

    private function handleSubscriptionActivated(Request $request)
    {
            $paypalSubscription = $request->input('resource');
            $subscriptionId = $paypalSubscription['id'];

            $status = $paypalSubscription['status'];

            $subscriptionOrder = SubscriptionOrder::where('paypal_subscription_id', $subscriptionId)
                ->where('current_subscription', true)
                ->first();
            Log::info(json_encode($subscriptionOrder));
            //if($billingReason == 'subscription_create') {
                if($subscriptionOrder && $subscriptionOrder->status == OrderStatusEnum::PENDING->value && $status == 'ACTIVE') {
                    $subscriptionOrder->status = OrderStatusEnum::PAID->value;
//                    if($subscriptionOrder->status == OrderStatusEnum::TRAIL->value) {
//                        $subscriptionOrder->trail_ended_at = now();
//                    } else {
                    $subscriptionOrder->save();
                    $user = $subscriptionOrder->user;
                    $user->status = StatusEnum::ACTIVATED->value;
                    $user->save();
//                    }


                }
//            } elseif($billingReason == 'subscription_cycle') {
//                $subscriptionOrder->current_subscription = 0;
//                $subscriptionOrder->save();
//                $user = $subscriptionOrder->user;
//
//                $newSubscriptionPayment = SubscriptionOrder::create([
//                    'amount' => $amountPaid / 100,
//                    'subscription_id' => $subscriptionId,
//                    'user_id' => $user->id,
//                    'payment_method_type' => 'stripe',
//                    'session_id' => $subscriptionOrder->session_id,
//                    'sub_total' => $amountPaid / 100,
//                    'status' => OrderStatusEnum::PAID->value,
//                ]);
//
//
//            }


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
        dd($request);
    }
}
