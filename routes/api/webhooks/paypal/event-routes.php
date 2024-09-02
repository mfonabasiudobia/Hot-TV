<?php

use App\Http\Controllers\Webhook\Paypal\EventController;

Route::post('event', EventController::class)->name('event');
