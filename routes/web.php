<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "App\Http\Livewire"],function () {


    // Route::get('logout', "Auth\Login@logout")->name('logout');

    Route::group(['middleware'=> []], function() {

        Route::get('/',"Home\Home")->name('home');

        Route::group(['namespace' => 'Auth'], function() {
            Route::get('login',"Login")->name('login');
            Route::get('signup',"Register")->name('register');
        });


    });
    
    
});
