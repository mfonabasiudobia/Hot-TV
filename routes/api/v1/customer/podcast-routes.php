<?php

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Api\V1\Customer\Podcast\ListController;
use App\Http\Controllers\Api\V1\Customer\Podcast\ShowController;
use App\Http\Middleware\SubscriptionStatus;

Route::prefix('podcast')
    ->name('podcast.')
    ->group(function() {
        Route::middleware(['auth:api', SubscriptionStatus::class])->group(function(){
            Route::get('list', ListController::class)->name('list');
            Route::get('show/{podcast}', ShowController::class)->name('show')->missing(function () {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            });

        });
    });
