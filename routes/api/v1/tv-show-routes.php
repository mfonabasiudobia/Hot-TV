<?php


use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Api\V1\TvShow\CategoryController;
use App\Http\Controllers\Api\V1\TvShow\DetailController;
use App\Http\Controllers\Api\V1\TvShow\EpisodeController;
use App\Http\Controllers\Api\V1\TvShow\ListController;

Route::prefix('tv-show')
    ->name('tv-show.')
    ->group(function() {
        Route::middleware('auth:api')->group(function() {
            Route::get('list/{category?}', ListController::class)->name('listing');
            Route::get('categories', CategoryController::class)->name('categories');
            Route::get('detail/{tvShow}', DetailController::class)->name('detail')->missing(function () {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            });

            Route::get('episode/{episode}', EpisodeController::class)->name('episode')->missing(function () {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            });
        });
    });
