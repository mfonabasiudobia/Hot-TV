<?php

use ArchiElite\AiWriter\Http\Controllers\AiWriterController;
use ArchiElite\AiWriter\Http\Controllers\SettingController;
use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'core', 'auth'])->prefix(BaseHelper::getAdminPrefix())->group(function () {
    Route::group(['prefix' => 'ai-writer', 'as' => 'ai-writer.', 'permission' => false], function () {
        Route::post('generate', [AiWriterController::class, 'generate'])->name('generate');
    });

    Route::group(['prefix' => 'ai-writer', 'as' => 'ai-writer.', 'permission' => 'ai-writer.settings'], function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::post('settings', [SettingController::class, 'update'])->name('settings')->middleware('preventDemo');
    });
});
