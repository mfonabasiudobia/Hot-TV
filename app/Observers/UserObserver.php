<?php

namespace App\Observers;

use App\Enums\User\StatusEnum;
use App\Mail\OtpNotification;
use App\Mail\OtpNotificationWeb;
use App\Mail\WelcomeNotification;
use App\Models\OtpVerification;
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
        if($oldStatus ==  StatusEnum::LOCKED->value && $newStatus == StatusEnum::ACTIVATED->value ) {

            Mail::to($user->email)->send(new WelcomeNotification($user));
            if(request()->is('api/*')) {
                $code = rand(111111, 999999);

                $otp = OtpVerification::where('email', $user->email)->first();
                if($otp) {
                    $otp->delete();
                }
                OtpVerification::updateOrCreate([
                    'email' => $user->email
                ], [
                    'otp' => $code
                ]);
                Mail::to($user->email)->send(new OtpNotification($user, $otp));
            } else {
                $url = URL::temporarySignedRoute('login', now()->addMinutes(15), [ 'email' => $user->email ]);
                Mail::to($user->email)->send(new OtpNotificationWeb($user, $url));
            }
        }
    }
}
