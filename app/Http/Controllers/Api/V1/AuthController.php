<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{

    public function login(Request $request)  {

            $validator = validator()->make(request()->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validator->fails()) return $this->fail("Failed to login", $validator->errors());

            try {

                throw_unless($user = AuthRepository::login($request->all()), "Incorrect login credentials");

                if(!$user->email_verified_at){
                      throw_unless($otp = AuthRepository::sendOtp($user->email, $user->temporary_token), "Failed to
                      send OTP");

                      return $this->success("Otp has been sent!",[
                        'otp' => $otp,
                        'user' => $user
                      ]);
                }


                return $this->success("Login Successful!",[
                    'token' => $user->createToken("APITOKEN")->plainTextToken,
                    'user' => $user
                ]);

            } catch (\Exception $e) {
                return $this->fail($e->getMessage());
            }

    }

    public function register(Request $request)  {

        $validator = validator()->make(request()->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()) return $this->fail($validator->errors()->first());

         try {

                throw_unless($user = AuthRepository::register($request->all()), "Failed to register User");

                throw_unless($otp = AuthRepository::sendOtp($user->email), "Failed to send OTP");

                return $this->success("Otp has been sent!",[
                    'otp' => $otp,
                    'user' => $user
                ]);

            } catch (\Exception $e) {
                return $this->fail($e->getMessage());
            }
    }

    public function resendOTP(Request $request)  {

        $validator = validator()->make(request()->all(), [
                'email' => 'required',
                'temporary_token' => 'required'
        ]);

        if($validator->fails()) return $this->fail($validator->errors()->first());

        try {
            throw_unless($otp = AuthRepository::sendOtp($request->email, $request->temporary_token), "Failed to send OTP");

            return $this->success("Otp has been sent!",[
                'otp' => $otp,
            ]);

        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }

    }


    public function forgotPassword(Request $request) {

        $validator = validator()->make(request()->all(), ['email' => 'required']);

        if($validator->fails()) return $this->fail($validator->errors()->first());

        try {
            throw_unless($token = AuthRepository::forgotPassword($request->email), "Failed to send password reset token");

            return $this->success("Password Reset token has been sent! to your mail", [
                'token' => $token
            ]);

        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }

    }


    public function resetPassword(Request $request) {

        $validator = validator()->make(request()->all(), [
            'email' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'temporary_token' => 'required'
        ]);

        if($validator->fails()) return $this->fail($validator->errors()->first());

        try {
            throw_unless($user = AuthRepository::resetPassword($request->all()), "Failed to reset password");

            return $this->success("Password reset successful", $user);

        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }

    }


    public function verifyOtp()  {

            $validator = validator()->make(request()->all(), [
                'email' => 'required',
                'otp' => 'required'
            ]);

            if($validator->fails()) return $this->fail($validator->errors()->first());

            try {
                throw_unless($user = AuthRepository::verifyOtp(request()->all()), 'Failed to Verify OTP, Please try again' );

                return $this->success("Login Successful!",[
                    'token' => $user->createToken("APITOKEN")->plainTextToken,
                    'user' => $user
                ]);


            } catch (\Exception $e) {
                return $this->fail($e->getMessage());
            }
    }


}
