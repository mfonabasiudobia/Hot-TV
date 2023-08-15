<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Botble\Plan\Http\Controllers\API',
], function () {
    Route::get('posts', 'PostController@index');
});
