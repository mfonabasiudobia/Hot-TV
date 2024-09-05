<?php

use App\Http\Controllers\Api\V1\ProfileController;

Route::prefix('profile')
    ->name('profile.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::get('', ProfileController::class)->name('driver');
        });
    });
