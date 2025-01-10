<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('job-progress', function () {
    return true;
    // return auth()->user()->super_user;
});

Broadcast::channel('customer.{userId}', function () {
    return true;
});

Broadcast::channel('driver.{userId}', function () {
    return true;
});

Broadcast::channel('tv-channel', function () {
    return true;
});


