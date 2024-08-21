<?php


Route::group(['prefix' => 'v1/customer', 'as' => 'v1.customer.'], function() {
    require __DIR__ . '/api/v1/customer/auth-routes.php';
    require __DIR__ . '/api/v1/customer/subscription-routes.php';
    require __DIR__ . '/api/v1/customer/user-routes.php';
    require __DIR__ . '/api/v1/customer/tv-show-routes.php';
    require __DIR__ . '/api/v1/customer/podcast-routes.php';
    require __DIR__ . '/api/v1/customer/stream-routes.php';
    require __DIR__ . '/api/v1/customer/ride-routes.php';
});

Route::group(['prefix' => 'v1/driver', 'as' => 'v1.driver.'], function() {
    require __DIR__ . '/api/v1/driver/auth-routes.php';
    require __DIR__ . '/api/v1/driver/ride-routes.php';
});
