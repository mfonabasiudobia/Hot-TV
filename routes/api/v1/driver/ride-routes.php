<?php

use App\Http\Controllers\Api\V1\Driver\Ride\AcceptRideController;

Route::prefix('ride')
    ->name('ride.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::get('accept', AcceptRideController::class)->name('accept');
        });
    });
