<?php


use App\Http\Controllers\Api\V1\Customer\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Customer\Auth\ForgotPasswordVerificationController;
use App\Http\Controllers\Api\V1\Driver\Auth\LoginController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\RegistrationController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\StripeCheckoutController;
use App\Http\Controllers\Api\V1\Customer\Auth\ResetPasswordController;

Route::prefix('auth')
    ->name('auth.')
    ->group(function() {
        Route::post('login', LoginController::class)->name('login');

//        Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');
//        Route::post('forgot-password-verification', ForgotPasswordVerificationController::class)->name('forgot-password-verification');
//        Route::middleware('auth:api')->group(function() {
//            Route::post('reset-password', ResetPasswordController::class)->name('forgot-password-verification');
//        });
        Route::get('stripe-checkout', StripeCheckoutController::class)->name('stripe-checkout');
    });
