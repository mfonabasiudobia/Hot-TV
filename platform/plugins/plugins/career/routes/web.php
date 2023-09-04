<?php

use ArchiElite\Career\Http\Controllers\CareerController;
use ArchiElite\Career\Http\Controllers\PublicController;
use ArchiElite\Career\Models\Career;

Route::middleware(['web', 'core'])->group(function () {
    Route::prefix(BaseHelper::getAdminPrefix())->middleware('auth')->group(function () {
        Route::resource('careers', CareerController::class);
    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
            Route::get(SlugHelper::getPrefix(Career::class, 'careers'), [PublicController::class, 'careers'])
                ->name('public.careers');
            Route::get(sprintf('%s/{slug}', SlugHelper::getPrefix(Career::class, 'careers')), [PublicController::class, 'career'])
                ->name('public.career');
        });
    }
});
