<?php

use App\Http\Controllers\Api\V1\Customer\Ride\DurationController;
use App\Http\Controllers\Api\V1\Customer\Ride\StreamingController;
use App\Http\Controllers\Api\V1\Customer\Ride\RequestController;
use App\Http\Controllers\Api\V1\Customer\Ride\Stripe\PaymentCancelController as StripePaymentCancelController;
use App\Http\Controllers\Api\V1\Customer\Ride\Stripe\PaymentVerificationController as StripePaymentVerificationController;
use App\Http\Controllers\Api\V1\Customer\Ride\Paypal\PaymentCancelController as PaypalPaymentCancelController;
use App\Http\Controllers\Api\V1\Customer\Ride\Paypal\PaymentVerificationController as PaypalPaymentVerificationController;
use App\Http\Controllers\Api\V1\Driver\Ride\Stripe\PaymentIntentController;

Route::prefix('ride')
    ->name('ride.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::post('request', RequestController::class)->name('request');
            Route::get('ride-durations', DurationController::class)->name('ride-durations');

            // Route::post('cancel/{ride}', [RideCancelContoller::class, 'store'])->name('streaming.store');
            Route::get('streaming/list', [StreamingController::class, 'index'])->name('streaming.index');
            Route::get('{ride}/streaming', [StreamingController::class, 'store'])->name('streaming.store');
            Route::get('{ride}/streaming/start', [StreamingController::class, 'start'])->name('streaming.start');
            Route::get('{ride}/streaming/end', [StreamingController::class, 'end'])->name('streaming.end');
            Route::get('{ride}/streaming/show', [StreamingController::class, 'end'])->name('streaming.show');
        });

        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function() {
            Route::get('payment-intent/{ride}', PaymentIntentController::class)->name('complete');
            Route::get('payment-verification', StripePaymentVerificationController::class)->name('payment-verification');
            Route::get('payment-cancel', StripePaymentCancelController::class)->name('payment-cancel');
        });

        Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function() {
            Route::get('payment-verification', PaypalPaymentVerificationController::class)->name('payment-verification');
            Route::get('payment-cancel', PaypalPaymentCancelController::class)->name('payment-cancel');
        });

    });
