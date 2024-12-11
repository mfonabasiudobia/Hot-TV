<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "App\Http\Livewire\Admin", "as" => "admin."],function () {

    Route::group(['middleware'=> ['AdminAuth']], function() {

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


         Route::group(['prefix'=> 'podcast', 'as' => 'podcast.'], function() {
                Route::get('create',"Podcast\Create")->name('create');
                Route::get('{id}/edit',"Podcast\Edit")->name('edit');
                Route::get('list',"Podcast\Home")->name('list');
         });

        Route::group(['prefix'=> 'shoutout', 'as' => 'shoutout.'], function() {
            Route::get('create',"Shoutout\Create")->name('create');
            Route::get('{id}/edit',"Shoutout\Edit")->name('edit');
            Route::get('list',"Shoutout\Home")->name('list');
        });


        Route::group(['prefix'=> 'tv-shows', 'as' => 'tv-show.'], function() {
            Route::get('/',"Shows\Home")->name('list');
            Route::get('create',"Shows\Create")->name('create');
            Route::get('{id}/edit',"Shows\Edit")->name('edit');
            Route::get('{slug}/show',"Shows\Show")->name('show');

            Route::group(['prefix'=> 'season', 'as' => 'season.'], function() {
                Route::get('create',"Season\Create")->name('create');
                Route::get('{id}/edit',"Season\Edit")->name('edit');
                Route::get('list',"Season\Home")->name('list');
            });


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

        Route::group(['namespace' => 'Season', 'prefix' => 'seasons'], function() {
            Route::get('/',"Home")->name('seasons.home');
            //Route::get('{slug}',"Show")->name('seasons.show');
        });

        Route::group(['prefix' => 'ride', 'as' => 'ride.'], function() {
            Route::get('durations', 'RideDuration\Home')->name('durations');
            Route::get('edit-duration/{id}', 'RideDuration\Edit')->name('edit-duration');
            Route::get('create-duration', 'RideDuration\Create')->name('create-duration');
            Route::get('/', 'Ride\Home')->name('list');
        });




    });


});
