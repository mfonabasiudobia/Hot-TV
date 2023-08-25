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

        Route::group(['namespace' => 'TvShows', 'prefix' => 'tv-shows'], function() {
            Route::get('/',"Home")->name('tv-shows.home');
            Route::get('{slug}',"Show")->name('tv-shows.show');
        });

        Route::group(['namespace' => 'Product', 'prefix' => 'products', 'as' => 'product.'], function() {
            Route::get('/',"Home")->name('home');
            Route::get('{slug}',"Show")->name('show');
        });


        Route::group(['namespace' => 'PedicabStream'], function() {
            Route::get('pedicab-streams',"Home")->name('pedicab-streams.home');
        });

        Route::group(['namespace' => 'Testimonials'], function() {
            Route::get('testimonials',"Home")->name('testimonials.home');
        });

        Route::group(['namespace' => 'ShoutOuts'], function() {
            Route::get('celebrity-shoutout',"Home")->name('celebrity-shoutout.home');
        });

        Route::group(['namespace' => 'Gallery'], function() {
            Route::get('gallery',"Home")->name('gallery.home');
        });

        Route::group(['namespace' => 'Blog', 'as' => 'blog.', 'prefix' => 'blog'], function() {
            Route::get('/',"Home")->name('home');
            Route::get('{slug}',"Show")->name('show');
        });

        Route::get('faqs',"Faqs")->name('faqs');
        Route::get('privacy-policy',"PrivacyPolicy")->name('privacy_policy');
        Route::get('cart',"Cart")->name('cart');
        Route::get('checkout',"Checkout")->name('checkout');
        Route::get('about',"About")->name('about');
        Route::get('contact',"Contact")->name('contact');


    });
    
    
    
});
