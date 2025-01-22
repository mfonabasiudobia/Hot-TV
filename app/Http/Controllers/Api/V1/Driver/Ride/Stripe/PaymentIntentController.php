<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride\Stripe;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Http\Request;

class PaymentIntentController extends Controller
{
    public function __invoke(Ride $ride, Request $request)
    {
        try {
            Stripe::setApiKey(gs()->payment_stripe_secret);

            $amount = $ride->price * 100;
            $currency = $request->input('currency', 'usd');

            $testPaymentMethod = 'pm_card_visa';

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['cashapp'],
                'capture_method' => 'automatic',
                // 'confirmation_method' => 'manual'
            ]);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['cashapp'],
                'mode' => 'payment',
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $paymentIntent->currency,
                            'product_data' => [
                                'name' => 'Ride' . $ride->id,
                            ],
                            'unit_amount' => $paymentIntent->amount,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'metadata' => [
                    'ride_id' => $ride->id,
                ],
                'success_url' => url('payment-verification/{CHECKOUT_SESSION_ID}'),
                // 'cancel_url' => 'https://example.com/cancel',
            ]);

            $ride->payment_intent_id = $paymentIntent->id;
            $ride->payment_status = 'pending';
            $ride->save();

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::RIDE_PAYMENT_INTENT_CREATED->value,
                'data' => [
                    'intentId' => $paymentIntent->id,
                    'clientSecret' => $paymentIntent->client_secret,
                    'session' => $session
                ]
            ]);

        } catch (\Throwable $th) {
            app_log_exception($th);

            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SERVER_ERROR->value,
                'error' => $th->getMessage()
            ]);
        }
    }
}
