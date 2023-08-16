<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware'=> [], 'namespace' => 'App\Http\Controllers\Api\V1'],function () {

    Route::get('/',function(){
         return json_encode(['status' => 'Success', 'message' => 'User Api is working']);
    });


    Route::group(['middleware'=> [],'prefix' => 'auth'],function () {
        Route::post('login', "AuthController@login");
        Route::post('register', "AuthController@register");
        Route::post('otp-verification', "AuthController@verifyOtp");
        Route::post('resend-otp', "AuthController@resendOTP");
        Route::post('send-password-reset', "AuthController@forgotPassword");
        Route::post('reset-password', "AuthController@resetPassword");
    });

    Route::apiResource('plans', "PlanController");
    
    Route::group(['middleware'=> ['auth:sanctum']],function () {
        Route::post('update-profile', "UserController@updateUser");
        Route::get('get-profile', "UserController@getProfile");
        Route::delete('delete-account', "UserController@deleteAccount");
    });

});
