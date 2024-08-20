<?php

use App\Http\Controllers\Api\V1\LiveChannel\ShowController;

Route::prefix('stream')
    ->name('stream.')
    ->group(function() {
        Route::middleware('auth:api')->group(function() {
            Route::put('live', ShowController::class)->name('live');
        });
    });
