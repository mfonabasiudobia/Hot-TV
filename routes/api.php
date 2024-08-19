<?php


Route::group(['prefix' => 'v1', 'as' => 'v1.'], function() {
    require __DIR__ . '/api/v1/auth-routes.php';
    require __DIR__ . '/api/v1/subscription-routes.php';
    require __DIR__ . '/api/v1/user-routes.php';
    require __DIR__ . '/api/v1/tv-show-routes.php';
    require __DIR__ . '/api/v1/podcast-routes.php';
});
