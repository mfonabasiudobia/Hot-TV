<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;
use Botble\SubscriptionPlan\Http\Livewire\Checkout;
// use Botble\SubscriptionPlan\Http\Controllers\Checkout as CheckoutSubmit;

Route::group(['namespace' => 'Botble\SubscriptionPlan\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
            Route::resource('', 'SubscriptionsController')->parameters(['' => 'subscriptions']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'SubscriptionsController@deletes',
                'permission' => 'subscriptions.destroy',
            ]);
        });

        Route::group(['prefix' => 'subscription-plans', 'as' => 'subscription-plan.'], function () {
            Route::resource('', 'SubscriptionPlanController')->parameters(['' => 'subscription-plan']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'SubscriptionPlanController@deletes',
                'permission' => 'subscription-plan.destroy',
            ]);
        });

        Route::group(['prefix' => 'subscription-features', 'as' => 'subscription-feature.'], function () {
            Route::resource('', 'SubscriptionFeatureController')->parameters(['' => 'subscription-feature']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'SubscriptionFeatureController@deletes',
                'permission' => 'subscription-feature.destroy',
            ]);
        });

        Route::group(['prefix' => 'subscription-orders', 'as' => 'subscription-order.'], function () {
            Route::resource('', 'SubscriptionOrderController')->parameters(['' => 'subscription-order']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'SubscriptionOrderController@deletes',
                'permission' => 'subscription-order.destroy',
            ]);
        });
    });
});
Route::group(['middleware'=> ['web', 'core']], function() {
    //Route::group(['namespace' => 'Botble\SubscriptionPlan\Http\Livewire'], function() {
        Route::get('subscription-checkout/{subscription}', Botble\SubscriptionPlan\Http\Livewire\Checkout::class)->name('subscription-checkout');
        
    //});
    Route::get('checkout', [Botble\SubscriptionPlan\Http\Controllers\Frontend\Checkout::class, 'checkoutSubmit'])->name('checkout-submit');
    Route::get('payment-verification', [Botble\SubscriptionPlan\Http\Controllers\Frontend\Checkout::class, 'paymentVerification'])->name('payment-verification');
});
