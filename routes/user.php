<?php

use Illuminate\Support\Facades\Route;



Route::group(['namespace' => "App\Http\Livewire\User", 'as' => 'user.'],function () {


    Route::group(['middleware'=> []], function() {
        Route::get('dashboard',"Dashboard\Home")->name('dashboard');

    });
    
    
    
});
