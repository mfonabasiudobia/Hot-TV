<?php

use App\Http\Controllers\Api\V1\Customer\User\UpdateProfileController;
use App\Http\Middleware\SubscriptionStatus;

Route::prefix('user')
    ->name('user.')
    ->group(function() {
        Route::middleware(['auth:api', SubscriptionStatus::class])->group(function() {
            Route::put('update-profile', UpdateProfileController::class)->name('update-profile');
        });
    });
