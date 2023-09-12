<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "App\Http\Livewire\Admin", "as" => "admin."],function () {

    Route::group(['middleware'=> []], function() {

        Route::get('dashboard',"Dashboard\Home")->name('dashboard');
        
        Route::group(['prefix'=> 'video'], function() {
            Route::get('create',"Video\Create")->name('video.create');
            Route::get('{id}/edit',"Video\Edit")->name('video.edit');
        });

        Route::get('calendar-view',"Calendar\Home")->name('calendar');
        Route::get('live-stream',"Live\Home")->name('live');


    });
    
    
});
