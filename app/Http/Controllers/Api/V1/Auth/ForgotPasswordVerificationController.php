<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ForgotPasswordVerificationRequest;
use App\Models\OtpVerification;
use Botble\ACL\Models\User;

class ForgotPasswordVerificationController extends Controller
{
    public function __invoke(ForgotPasswordVerificationRequest $request)
    {
        $otp = $request->input('otp');

        $verify = OtpVerification::where('otp', $otp);

        if($verify->exists()) {
            $otpModel = $verify->first();
            $user = User::where('email', $otpModel->email)->first();
            $otpModel->delete();
            $token = $user->createToken('appToken')->accessToken;
            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::OTP_VERIFIED->value,
                'data' => [
                    'token' => $token
                ]
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::OTP_NOT_VERIFIED->value,
            ], 422);
        }
    }
}
