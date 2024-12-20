<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride\Stripe;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\PaymentMethod;

class CompletePaymentController extends Controller
{
    public function __invoke(Ride $ride, Request $request)
    {
        try {
            Stripe::setApiKey(gs()->payment_stripe_secret);

            $intentId = $request->input('payment_intent_id');

            $paymentIntent = PaymentIntent::retrieve($intentId);

            if ($paymentIntent->status === 'succeeded') {
                // Payment is already completed
                return response()->json(['message' => 'Payment already succeeded.']);
            }

            $paymentIntent->confirm();

            if ($paymentIntent->status === 'succeeded') {
                return response()->json([
                    'message' => 'Payment succeeded.',
                    'payment_intent' => $paymentIntent,
                ]);
            }

            return response()->json([
                'message' => 'Payment not completed.',
                'status' => $paymentIntent->status,
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
