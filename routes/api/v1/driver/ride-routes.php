<?php

use App\Http\Controllers\Api\V1\Driver\Ride\AcceptRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\StartRideController;
use App\Http\Controllers\Api\V1\Driver\Ride\DriverArrivedController;
use App\Http\Controllers\Api\V1\Driver\Ride\CompleteRideController;

Route::prefix('ride')
    ->name('ride.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::put('accept/{ride}', AcceptRideController::class)->name('accept');
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
    });
