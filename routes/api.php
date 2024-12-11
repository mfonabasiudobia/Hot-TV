<?php


use App\Http\Controllers\Api\V1\Customer\Auth\Registration\CheckoutPaypalController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\PaypalCheckoutController;
use App\Http\Controllers\Api\V1\Customer\Auth\Registration\StripeCheckoutController;

Route::group(['prefix' => 'v1/customer', 'as' => 'v1.customer.'], function() {
    require __DIR__ . '/api/v1/customer/auth-routes.php';
    require __DIR__ . '/api/v1/customer/subscription-routes.php';
    require __DIR__ . '/api/v1/customer/user-routes.php';
    require __DIR__ . '/api/v1/customer/tv-show-routes.php';
    require __DIR__ . '/api/v1/customer/podcast-routes.php';
    require __DIR__ . '/api/v1/customer/stream-routes.php';
    require __DIR__ . '/api/v1/customer/ride-routes.php';
    require __DIR__ . '/api/v1/customer/ecommerce-routes.php';
    require __DIR__ . '/api/v1/customer/profile-routes.php';
    require __DIR__ . '/api/v1/customer/gallery-routes.php';
    require __DIR__ . '/api/v1/customer/dashboard-routes.php';
});

Route::group(['prefix' => 'v1/driver', 'as' => 'v1.driver.'], function() {
    require __DIR__ . '/api/v1/driver/auth-routes.php';
    require __DIR__ . '/api/v1/driver/ride-routes.php';
    require __DIR__ . '/api/v1/driver/profile-routes.php';

});

Route::group(['prefix' => 'v1/webhooks/stripe', 'as' => 'v1.webhooks.stripe.'], function() {
    require __DIR__ . '/api/webhooks/stripe/event-routes.php';
});

Route::group(['prefix' => 'v1/webhooks/paypal', 'as' => 'v1.webhooks.paypal.'], function() {
    require __DIR__ . '/api/webhooks/paypal/event-routes.php';
});


Route::group(['prefix' => 'v1/subscribe', 'as' => 'v1.subscribe.'], function() {
    Route::get('stripe-checkout/{session_id}', StripeCheckoutController::class)->name('stripe-checkout');
    //Route::get('paypal-checkout', PaypalCheckoutController::class)->name('paypal-checkout');
    Route::get('paypal-checkout-success', PaypalCheckoutController::class)->name('paypal-checkout-success');

});

Route::get('sendmail', "App\Http\Controllers\Api\V1\AuthController@sendEmail");
