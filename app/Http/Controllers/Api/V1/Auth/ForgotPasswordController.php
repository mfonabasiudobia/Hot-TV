<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ForgotPasswordRequest;
use App\Repositories\AuthRepository;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request)
    {

        $email = $request->input('email');
        AuthRepository::forgotPassword($email);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::FORGOT_PASSWORD_OTP_SENT_TO_EMAIL->value,
        ]);
    }
}
