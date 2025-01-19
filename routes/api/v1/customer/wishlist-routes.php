<?php

use App\Http\Controllers\Api\V1\Customer\Wishlist\StoreWishListController;
use App\Http\Middleware\SubscriptionStatus;

Route::prefix('wishlist')
    ->name('wishlist.')
    ->group(function() {
        Route::middleware(['auth:api', SubscriptionStatus::class])->group(function(){
            Route::post('', StoreWishListController::class)->name('watch-lists');
        });
    });
