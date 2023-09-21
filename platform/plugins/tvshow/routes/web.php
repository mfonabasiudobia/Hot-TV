<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Tvshow\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'tvshows', 'as' => 'tvshow.'], function () {
            Route::resource('', 'TvshowController')->parameters(['' => 'tvshow']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'TvshowController@deletes',
                'permission' => 'tvshow.destroy',
            ]);
        });
    });

});
