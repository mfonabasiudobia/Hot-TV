<?php


use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordVerificationController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\Registration\RegistrationController;
use App\Http\Controllers\Api\V1\Auth\Registration\StripeCheckoutController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;

Route::prefix('auth')
    ->name('auth.')
    ->group(function() {
        Route::post('login', LoginController::class)->name('login');
        Route::post('registration', RegistrationController::class)->name('registration');
        Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');
        Route::post('forgot-password-verification', ForgotPasswordVerificationController::class)->name('forgot-password-verification');
        Route::middleware('auth:api')->group(function() {
            Route::post('reset-password', ResetPasswordController::class)->name('forgot-password-verification');
        });
        Route::get('stripe-checkout', StripeCheckoutController::class)->name('stripe-checkout');
    });
