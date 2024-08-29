<?php

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Cart\AddController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Cart\RemoveController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Checkout\CheckoutController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Checkout\PaypalPaymentCancelController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Checkout\PaypalPaymentVerificationController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Checkout\StripePaymentVerificationController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Product\DetailController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Product\ListController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\Cart\ListController as CartListController;
use App\Http\Controllers\Api\V1\Customer\Ecommerce\UpdateQuantityController;

Route::prefix('ecommerce')
    ->name('ecommerce.')
    ->group(function() {
        Route::middleware('auth:api')->group(function(){
            Route::get('products', ListController::class)->name('products');
            Route::get('detail/{product}', DetailController::class)->name('detail')->missing(function () {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            });
            Route::post('add-to-cart', AddController::class)->name('add-to-cart');
            Route::get('cart', CartListController::class)->name('list');
            Route::put('cart/update-quantity/{product}/{rowId}', UpdateQuantityController::class)->name('cart.update-quantity');
            Route::delete('cart/remove/{rowId}', RemoveController::class)->name('cart.remove');

            Route::prefix('checkout')
                ->name('checkout.')
                ->group(function(){
                    Route::post('', CheckoutController::class)->name('checkout');

                });
        });
        Route::prefix('stripe')
            ->name('stripe.')
            ->group(function(){
                Route::get('payment-success/{sessionId}', StripePaymentVerificationController::class)->name('payment.success');
            });

        Route::prefix('paypal')
            ->name('paypal.')
            ->group(function(){
                Route::get('payment-success', PaypalPaymentVerificationController::class)->name('payment.success');
                Route::get('payment-cancel', PaypalPaymentCancelController::class)->name('payment.cancel');
            });


    });
