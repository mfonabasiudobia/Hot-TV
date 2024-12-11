<?php

use App\Http\Controllers\Api\V1\Customer\Dashboard\ScreenshotController;
use App\Http\Controllers\Api\V1\Customer\Dashboard\WatchHistoryController;
use App\Http\Controllers\Api\V1\Customer\Dashboard\WatchListController;
use App\Http\Controllers\Api\V1\Customer\Dashboard\WishListController;

Route::prefix('dashboard')
    ->name('dashboard.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::get('watch-lists', WatchListController::class)->name('watch-lists');
            Route::get('wish-lists', WishListController::class)->name('wish-lists');
            Route::get('screen-shots', ScreenshotController::class)->name('screen-shots');
            Route::get('watch-history', WatchHistoryController::class)->name('watch-history');

        });
    });
