<?php

use Illuminate\Support\Facades\Route;


Route::get('jsdjsjjs', function(){
    return 444;
})->name('public.index');


Route::group(['namespace' => "App\Http\Livewire"],function () {


    // Route::get('logout', "Auth\Login@logout")->name('logout');

    Route::group(['middleware'=> []], function() {

        Route::get('/',"Home\Home")->name('home');

        Route::group(['namespace' => 'Auth'], function() {
            Route::get('login',"Login")->name('login');
            Route::get('signup',"Register")->name('register');
        });

        Route::group(['namespace' => 'LiveChannel'], function() {
            Route::get('live-channel',"Show")->name('live-channel.show');
        });

        Route::group(['namespace' => 'TvShows'], function() {
            Route::get('tv-shows',"Home")->name('tv-shows.home');
            Route::get('{slug}',"Show")->name('tv-shows.show');
        });


    });
    
    
    
});
