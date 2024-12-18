<?php

use App\Http\Controllers\Api\V1\Driver\Ride\AcceptRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\StartRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\DriverArrivedController;
use App\Http\Controllers\Api\V1\Driver\Ride\CompleteRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\RejectRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\Stripe\PaymentIntentController;

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
            Route::put('payment-intent/{ride}', PaymentIntentController::class)->name('complete');
        });
    });
