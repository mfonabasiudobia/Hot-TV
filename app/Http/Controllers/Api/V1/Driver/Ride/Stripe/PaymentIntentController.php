<?php

namespace App\Http\Controllers\Api\V1\Driver\Ride\Stripe;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentIntentController extends Controller
{
    public function __invoke(Ride $ride)
    {
        try {
            Stripe::setApiKey(gs()->payment_stripe_secret);

            $amount = $request->price * 100;
            $currency = $request->input('currency', 'usd');

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['card'], // Accept only card payments
            ]);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::PAYMENT_INTENT_CREATED->value,
                'data' => [
                    'clientSecret' => $paymentIntent->client_secret,
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
