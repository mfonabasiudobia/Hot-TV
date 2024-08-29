<?php

use App\Http\Controllers\Webhook\Stripe\EventController;

Route::post('event', EventController::class)->name('event');
