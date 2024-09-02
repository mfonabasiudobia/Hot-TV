<?php

namespace App\Http\Controllers\Webhook\Paypal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        dd($request);
    }
    private function handleSubscriptionUpdated(Request $request)
    {
        dd($request);
    }

    private function handleSubscriptionCancelled(Request $request)
    {
        dd($request);
    }

    private function handleSubscriptionExpired(Request $request)
    {
        dd($request);
    }
}
