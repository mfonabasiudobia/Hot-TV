<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request)
    {
        $password = $request->input('password');

        $user = Auth::user();
        $user->password = bcrypt($password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::PASSWORD_RESET_SUCCESS->value,
        ]);
    }
}
