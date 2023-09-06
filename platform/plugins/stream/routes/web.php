<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Stream\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'streams', 'as' => 'stream.'], function () {
            Route::resource('', 'StreamController')->parameters(['' => 'stream']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'StreamController@deletes',
                'permission' => 'stream.destroy',
            ]);
        });
    });

});
