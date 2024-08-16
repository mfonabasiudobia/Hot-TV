<?php

namespace App\Observers;

use App\Enums\User\StatusEnum;
use App\Mail\OtpNotificationWeb;
use App\Mail\WelcomeNotification;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Mail;
use URL;

class UserObserver
{
    public function updated(User $user): void
    {
        $oldStatus = $user->getOriginal('status');
        $newStatus = $user->status;
        if($oldStatus ==  StatusEnum::LOCKED->value && $newStatus = StatusEnum::ACTIVATED->value ) {

            Mail::to($user->email)->send(new WelcomeNotification($user));
            $url = URL::temporarySignedRoute('login', now()->addMinutes(15), [ 'email' => $user->email ]);
            Mail::to($user->email)->send(new OtpNotificationWeb($user, $url));
        }
    }
}
