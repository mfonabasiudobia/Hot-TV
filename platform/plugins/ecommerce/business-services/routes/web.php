<?php

use Botble\Base\Facades\BaseHelper;
use Botble\BusinessService\Http\Controllers\PackageController;
use Botble\BusinessService\Http\Controllers\PublicController;
use Botble\BusinessService\Http\Controllers\ServiceCategoryController;
use Botble\BusinessService\Http\Controllers\ServiceController;
use Botble\BusinessService\Models\Package;
use Botble\BusinessService\Models\Service;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'core'])->group(function () {
    Route::middleware('auth')->prefix(BaseHelper::getAdminPrefix() . '/business-services')->name('business-services.')->group(function () {
        Route::resource('service-categories', ServiceCategoryController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('packages', PackageController::class);
    });

    Route::get(sprintf('%s/{slug}', SlugHelper::getPrefix(Service::class, 'services')), [PublicController::class, 'service'])
        ->name('public.service');

    Route::get(sprintf('%s/{slug}', SlugHelper::getPrefix(Package::class, 'packages')), [PublicController::class, 'package'])
        ->name('public.package');
});
