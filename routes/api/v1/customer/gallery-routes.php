<?php

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Api\V1\Customer\Gallery\DetailController;
use App\Http\Controllers\Api\V1\Customer\Gallery\ListController;

Route::prefix('gallery')
    ->name('gallery.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::get('list', ListController::class)->name('lists');
            Route::get('detail/{gallery}', DetailController::class)->name('detail')->missing(function () {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            });
        });
    });
