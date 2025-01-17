<?php

namespace App\Repositories;

use App\Models\OtpVerification;
use App\Models\User;
use App\Mail\WelcomeNotification;
use App\Mail\OtpNotification;
use App\Mail\OtpNotificationWeb;
use App\Mail\ForgotPasswordNotificationApi;
use App\Mail\ForgotPasswordNotificationWeb;
use Botble\ACL\Models\Role;
use App\Enums\User\RoleEnum;
use Mail;
use DB;
use Exception;
use URL;
use Hash;

class AuthRepository {


    public static function login($data)  {
            auth()->attempt($data, true);

            $user = auth()->user();

            if($user){
                if($user->activations()->count() === 0){
                    session()->flash('confirmation-email-message', true);

                    session()->put("confirmation-email", $user->email);

                    self::sendOtp($user->email);

                    auth()->logout();

                    throw new \Exception("Please verify your email", 1);
                }
            }

            return $user;
    }

    public static function register($data, $role = 'subscriber') : User {
        $user = User::create(array_merge($data,
        [
            'password' => bcrypt($data['password']),
            'temporary_token' => str()->random(15)
        ]));

        //Mail::to($user->email)->send(new WelcomeNotification($user));
        if($role === 'subscriber') {
            $roleRecord = Role::where('slug', RoleEnum::SUBSCRIBER->value)->first();
        }else{
            $roleRecord = Role::where('slug', RoleEnum::DRIVER->value)->first();
        }

        if(!$roleRecord) {
            \Log::warning('role' . $role . 'does not exist');
            throw new Exception('role' . $role . 'does not exist');
        }

        $user->roles()->attach([$roleRecord->id]);

        return $user->refresh();
    }

    public static function registerAsSubscriber($data) : User {
        $user = User::create(array_merge($data,
            [
                'password' => bcrypt($data['password']),
                'temporary_token' => str()->random(15)
            ]));

        $subscriberRole = Role::updateOrCreate([
            'slug' => 'subscriber',
            'name' => 'Subscriber'
        ], [
            'permissions' => [],
            'description' => 'Subscriber',
            'is_default' => 0,
            'create_by' => 1,
            'updated_by' => 1
        ]);

        $user->roles()->attach($subscriberRole->id); //Assigning User to a Role of Streamer

        return $user->refresh();
    }

    public static function verifyOtp($data)  {
        //This function is stictly for authentication purpose (verifying user's email through otp or signature)
        if (request()->is('api/*')) {

            $verify = DB::table('otp_verifications')->where('email', $data['email'])->where('otp', $data['otp'])->first();

            if($verify){
                throw_if($verify->created_at <= now()->subMinutes(10), "Token has expired, please try again");

                $user = self::getUserByEmail($data['email']);

                auth()->login($user);

                $user->update(['email_verified_at' => now() ]);

                DB::table('otp_verifications')->where('email', $data['email'])->delete();

                return auth()->user(); //use this to fetch tokens in the controller
            }
        }else{
            $user = self::getUserByEmail($data['email']);

            if($user->activations()->count() === 0 ){
                $user->activations()->create([
                    'completed' => 1,
                    'code' => str()->random(12)
                ]);

                $user->update(['email_verified_at' => now() ]);

                session()->flash('verification-email-message', true);
            }else{

                session()->flash('email-already-verified-message', true);

            }


            return $user;
        }

        return false;
    }

    public static function forgotPassword($email) : bool | int  {

        $code = rand(111111, 999999);

        if($user = self::getUserByEmail($email)){


            if (request()->is('api/*')) {

                OtpVerification::updateOrCreate([
                   'email' => $email
                ], [
                    'otp' => $code
                ]);

//                DB::table('otp_verifications')->where('email', $email)->delete(); //disable previous otps
//
//                DB::table('otp_verifications')->insert([ 'email' => $email, 'otp' => $code, 'created_at' => now() ]);

                //Send Forgot token Mail to User here
                Mail::to($email)->send(new ForgotPasswordNotificationApi($user, $code));
            }else{

                //Send Forgot token Mail to User here
                $url = URL::temporarySignedRoute('reset_password', now()->addMinutes(15), [ 'email' => $email ]);

                Mail::to($email)->send(new ForgotPasswordNotificationWeb($user, $url));
            }

            return $code;
        }

        return false;
    }

    public static function resetPassword($data) : bool | User {

         if (request()->is('api/*')) {
            //We may disable the first condition soon
             if($user = self::getUserByEmail($data['email'], $data['temporary_token'])){

                throw_unless(Hash::check($data['old_password'], $user->password), "Old Password does not match!");

                $user->update([
                    'password' => bcrypt($data['new_password'])
                ]);

                return $user;
            }
         }else{

            if($user = self::getUserByEmail($data['email'])){

                $user->update([
                    'password' => bcrypt($data['password'])
                ]);

                return $user;
            }

         }

        return false;
    }


    public static function sendOtp($email, $temporaryToken = null) : bool | int
    {
            $otp = rand(111111, 999999);

            if($user = self::getUserByEmail($email, $temporaryToken)){

                DB::table('otp_verifications')->where('email', $email)->delete(); //disable previous otps

                if(request()->is('api/*')) {
                    $url = URL::temporarySignedRoute('login', now()->addMinutes(15), [ 'email' => $email ]);
                    Mail::to($user->email)->send(new OtpNotificationWeb($user, $url));

                 }else{
                    //Send Forgot token Mail to User here
                    $url = URL::temporarySignedRoute('login', now()->addMinutes(15), [ 'email' => $email ]);

                    Mail::to($email)->send(new OtpNotificationWeb($user, $url));
                 }

                return  $otp;
        }

        return false;
    }

    public static function getUserByEmail($email, $temporaryToken = null) : User | null {
        return User::where('email', $email)->when($temporaryToken, function($q) use($temporaryToken) {
            $q->where('temporary_token', $temporaryToken);
        })->first();
    }



}
