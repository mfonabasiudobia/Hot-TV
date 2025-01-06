<?php

use App\Http\Controllers\Api\V1\Customer\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Customer\Auth\ForgotPasswordVerificationController;
use App\Http\Controllers\Api\V1\Customer\Auth\LoginController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\PaymentMethodController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\RegistrationController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\StripeSubscriptionCheckoutController;
use App\Http\Controllers\Api\V1\Customer\Auth\ResetPasswordController;

Route::prefix('auth')
    ->name('auth.')
    ->group(function() {
        Route::post('login', LoginController::class)->name('login');
        Route::post('registration', RegistrationController::class)->name('registration');
        Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');
        Route::post('forgot-password-verification', ForgotPasswordVerificationController::class)->name('forgot-password-verification');
        Route::get('payment-methods', PaymentMethodController::class)->name('payment-methods');
        Route::post('stripe-payment-url', StripeSubscriptionCheckoutController::class)->name('subscription-checkout');
        Route::middleware('auth:api')->group(function() {
            Route::post('reset-password', ResetPasswordController::class)->name('reset-password');
        });
    });
