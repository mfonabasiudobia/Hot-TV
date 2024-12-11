<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth\Registration;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    public function __invoke()
    {
        $paymentMethods = [];
            if(gs()->payment_stripe_status) {
                $paymentMethods[] = 'stripe';
            }
            if(gs()->payment_paypal_status) {
                $paymentMethods[] = 'paypal';
            }

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::PAYMENT_METHODS->value,
                'data' => $paymentMethods
            ]);
    }
}
