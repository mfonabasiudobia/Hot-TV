<?php

use App\Http\Controllers\Api\V1\Subscrition\PlanController;

Route::prefix('subscription')
    ->name('subscription.')
    ->group(function() {
        //Route::middleware('auth:api')->group(function() {
            Route::get('plans', PlanController::class)->name('plans');
        //});
    });
