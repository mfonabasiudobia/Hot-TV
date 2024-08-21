<?php

use App\Http\Controllers\Api\V1\Driver\Ride\CreateController;

Route::prefix('ride')
    ->name('ride.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::post('create', CreateController::class)->name('create');
        });
    });
