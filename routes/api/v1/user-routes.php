<?php

use App\Http\Controllers\Api\V1\User\UpdateProfileController;

Route::prefix('user')
    ->name('user.')
    ->group(function() {
        Route::middleware('auth:api')->group(function() {
            Route::put('update-profile', UpdateProfileController::class)->name('update-profile');
        });
    });
