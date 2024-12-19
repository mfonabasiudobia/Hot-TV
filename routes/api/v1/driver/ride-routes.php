<?php

use App\Http\Controllers\Api\V1\Driver\Ride\AcceptRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\StartRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\DriverArrivedController;
use App\Http\Controllers\Api\V1\Driver\Ride\CompleteRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\RejectRideController;
// use App\Http\Controllers\Api\V1\Driver\Ride\Stripe\CompletePaymentController;
use App\Http\Controllers\Api\V1\Driver\Ride\Stripe\PaymentIntentController;
use App\Http\Controllers\Api\V1\Driver\Ride\DriverStatusContoller;

Route::prefix('ride')
    ->name('ride.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::put('accept/{ride}', AcceptRideController::class)->name('accept');
        });

        Route::middleware('auth:api')->group(function(){
            Route::put('reject/{ride}', RejectRideController::class)->name('reject');
        });


        Route::middleware('auth:api')->group(function(){
            Route::put('arrived/{ride}', DriverArrivedController::class)->name('arrived');
        });

        Route::middleware('auth:api')->group(function(){
            Route::put('start/{ride}', StartRideController::class)->name('start');
        });

        Route::middleware('auth:api')->group(function(){
            Route::put('complete/{ride}', CompleteRideController::class)->name('complete');
        });

        Route::middleware('auth:api')->group(function(){
            Route::put('set-online-status', [DriverStatusContoller::class, 'setOlnine'])->name('online-status');
        });

        Route::middleware('auth:api')->group(function(){
            Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function() {
                Route::get('payment-intent/{ride}', PaymentIntentController::class)->name('stripe.payment-intent');
            });

            // Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function() {
            //     Route::post('complete-payment', CompletePaymentController::class)->name('stripe.complete-payment');
            // });
        });
    });
