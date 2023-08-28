<?php

namespace App\Repositories;

use App\Models\User;
use App\Mail\SignupNotification;
use App\Mail\OtpNotification;
use App\Mail\forgotPasswordNotification;
use Mail;
use DB;
use URL;
use Hash;

class AuthRepository {


    public static function login($data)  {
            auth()->attempt($data, true);

            return auth()->user();
    }

    public static function register($data) : User {
        $user = User::create(array_merge($data, 
        [
            'password' => bcrypt($data['password']),
            'temporary_token' => str()->random(15)
        ]));

        return $user->refresh();
    }



    public static function verifyOtp($data)  {

        $verify = DB::table('otp_verifications')->where('email', $data['email'])->where('otp', $data['otp'])->first();

        if($verify){
            throw_if($verify->created_at <= now()->subMinutes(10), "Token has expired, please try again");

            $member = self::getMemberByEmail($data['email']);

            auth('member')->login($member);

            $member->update(['email_verified_at' => now() ]);

            DB::table('otp_verifications')->where('email', $data['email'])->delete();

            return auth('member')->user(); //use this to fetch tokens in the controller
        }


        return false;
    }


    public static function forgotPassword($email) : bool | int  {

        $code = rand(111111, 999999);

        if($user = self::getMemberByEmail($email)){


            if (request()->is('api/*')) {
                DB::table('otp_verifications')->where('email', $email)->delete(); //disable previous otps

                DB::table('otp_verifications')->insert([ 'email' => $email, 'otp' => $rand, 'created_at' => now() ]);

                //Send Forgot token Mail to User here
                Mail::to($email)->send(new forgotPasswordNotification($user, $code, 'api'));
            }else{

                //Send Forgot token Mail to User here
                $code = URL::temporarySignedRoute('reset_password', now()->addMinutes(30), [ 'email' => $email ]);

                Mail::to($email)->send(new forgotPasswordNotification($user, $code, 'web'));

                // Mail::send('emails.forgot-password-notification', ['user' => $user, 'code' => $code ], function($q) use ($email){
                //     // $q->from('noreply@uniskills.net', 'Uniskills Forgot Password');
                //     $q->to($email)->subject('Reset Password');
                // });

            }
            

            return $rand;
        }

        return false;
    }

    public static function resetPassword($data) : bool | User {

        if($member = self::getMemberByEmail($data['email'], $data['temporary_token'])){

            throw_unless(Hash::check($data['old_password'], $member->password), "Old Password does not match!");

            $member->update([
                'password' => bcrypt($data['new_password'])
            ]);

            return $member;
        }

        return false;
    }


    public static function sendOtp($email, $temporaryToken = null) : bool | int 
    {
            $rand = rand(111111, 999999);

            if($member = self::getMemberByEmail($email, $temporaryToken)){

                DB::table('otp_verifications')->where('email', $email)->delete(); //disable previous otps

                // Mail::to($member->email)->send(new OtpNotification($member, $rand)); 

                DB::table('otp_verifications')->insert([ 'email' => $email, 'otp' => $rand, 'created_at' => now() ]);

                return  $rand;
            }

            return false;
    }

    public static function getMemberByEmail($email, $temporaryToken = null) : User | null {
        return User::where('email', $email)->when($temporaryToken, function($q) use($temporaryToken) {
            $q->where('temporary_token', $temporaryToken);
        })->first();
    }

   

}
