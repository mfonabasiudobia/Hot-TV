<?php

use App\Http\Controllers\Api\V1\Customer\Ride\RequestController;
use App\Http\Controllers\Api\V1\Customer\Ride\Stripe\PaymentCancelController as StripePaymentCancelController;
use App\Http\Controllers\Api\V1\Customer\Ride\Stripe\PaymentVerificationController as StripePaymentVerificationController;
use App\Http\Controllers\Api\V1\Customer\Ride\Paypal\PaymentCancelController as PaypalPaymentCancelController;
use App\Http\Controllers\Api\V1\Customer\Ride\Paypal\PaymentVerificationController as PaypalPaymentVerificationController;

Route::prefix('ride')
    ->name('ride.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::post('request', RequestController::class)->name('request');
        });

        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function() {
            Route::get('payment-verification', StripePaymentVerificationController::class)->name('payment-verification');
            Route::get('payment-cancel', StripePaymentCancelController::class)->name('payment-cancel');
        });

        Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function() {
            Route::get('payment-verification', PaypalPaymentVerificationController::class)->name('payment-verification');
            Route::get('payment-cancel', PaypalPaymentCancelController::class)->name('payment-cancel');
        });

    });
