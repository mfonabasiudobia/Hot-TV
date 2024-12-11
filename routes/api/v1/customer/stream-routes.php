<?php

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Api\V1\Customer\LiveChannel\ShowController;

Route::prefix('stream')
    ->name('stream.')
    ->group(function() {
        Route::middleware('auth:api')->group(function() {
            Route::get('live/{stream}', ShowController::class)->name('live')->missing(function () {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            });
        });
    });
