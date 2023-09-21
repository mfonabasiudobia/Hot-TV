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

        Route::group(['prefix'=> 'show-categories', 'as' => 'show-category.'], function() {
            Route::get('/',"ShowCategory\Home")->name('list');
            Route::get('create',"ShowCategory\Create")->name('create');
            Route::get('{id}/edit',"ShowCategory\Edit")->name('edit');
        });

        Route::group(['prefix'=> 'tv-shows', 'as' => 'tv-show.'], function() {
            Route::get('/',"Shows\Home")->name('list');
            Route::get('create',"Shows\Create")->name('create');
            Route::get('{id}/edit',"Shows\Edit")->name('edit');
            Route::get('{slug}/show',"Shows\Show")->name('show');

               Route::group(['prefix'=> 'episode', 'as' => 'episode.'], function() {
                    Route::get('create',"Episode\Create")->name('create');
                    Route::get('{id}/edit',"Episode\Edit")->name('edit');
                    Route::get('list',"Episode\Home")->name('list');
               });   
               
               Route::group(['prefix'=> 'cast', 'as' => 'cast.'], function() {
                    Route::get('create/{tvslug?}',"Cast\Create")->name('create');
                    Route::get('edit/{id}/{tvslug?}',"Cast\Edit")->name('edit');
                    Route::get('list',"Cast\Home")->name('list');
               });
        });

     


    });
    
    
});
