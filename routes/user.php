<?php

use Illuminate\Support\Facades\Route;



Route::group(['namespace' => "App\Http\Livewire\User", 'as' => 'user.'],function () {


    Route::group(['middleware'=> ['UserAuth']], function() {
        Route::get('dashboard',"Dashboard\Home")->name('dashboard');
        Route::get('profile',"Profile\Home")->name('profile');
        Route::get('subscription',"Profile\Subscription")->name('subscription');

    });



});
