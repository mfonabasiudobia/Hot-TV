<?php

use App\Http\Controllers\Api\V1\Driver\Ride\AcceptRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\StartRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\DriverArrivedController;
use App\Http\Controllers\Api\V1\Driver\Ride\CompleteRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\RejectRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\Stripe\CompletePaymentController;
use App\Http\Controllers\Api\V1\Driver\Ride\Stripe\PaymentIntentController;
use App\Http\Controllers\Api\V1\Driver\Ride\DriverStatusController;
use App\Http\Controllers\Api\V1\Driver\Ride\LocationController;
use App\Http\Controllers\Api\V1\Driver\Ride\RideListController;

Route::prefix('ride')
    ->name('ride.')
    ->middleware('auth:api')
    ->group(function() {
        Route::get('list', RideListController::class)->name('rides.list');

        Route::put('accept/{ride}', AcceptRideController::class)->name('accept');
        Route::put('reject/{ride}', RejectRideController::class)->name('reject');
        Route::put('arrived/{ride}', DriverArrivedController::class)->name('arrived');
        Route::put('start/{ride}', StartRideController::class)->name('start');
        Route::put('complete/{ride}', CompleteRideController::class)->name('complete');
        Route::put('set-online-status', [DriverStatusController::class, 'setOnline'])->name('online-status');
        Route::post('/location', LocationController::class)->name('location.update');

        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function() {
            Route::get('payment-intent/{ride}', PaymentIntentController::class)->name('stripe.payment-intent');
            Route::post('complete-payment', CompletePaymentController::class)->name('stripe.complete-payment');
        });
    });
