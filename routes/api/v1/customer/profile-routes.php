<?php

use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Middleware\SubscriptionStatus;

Route::prefix('profile')
    ->name('profile.')
    ->group(function() {
        Route::middleware(['auth:api', SubscriptionStatus::class])->group(function(){
            Route::get('', ProfileController::class)->name('driver');
        });
    });
