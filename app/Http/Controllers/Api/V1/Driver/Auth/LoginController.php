<?php

namespace App\Http\Controllers\Api\V1\Driver\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Driver\Auth\LoginRequest;
use App\Http\Resources\Api\V1\Customer\Auth\AuthUserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if(config('app.env') == 'production') {
            $throttleKey = $request->input('email');
            $hit = RateLimiter::hit($throttleKey, 1800);

            if ($hit > 2) {
                $remainingSeconds = RateLimiter::availableIn($throttleKey);
                $remainingMinutes = intval(ceil($remainingSeconds / 60));
                if ($remainingMinutes == 0) {
                    RateLimiter::clear($throttleKey);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => ApiResponseMessageEnum::TOO_MANY_LOGIN_ATTEMPTS->value,
                    ], 429);
                }
            }
        }

        $credentials = $request->only(['email', 'password']);

        if(Auth::attempt($credentials, true)) {
            $user = Auth::user();

            if(!$user->inRole(RoleEnum::DRIVER->value)) {
                return response()->json([
                    'success' => false,
                    'message' => ApiResponseMessageEnum::YOU_DO_NOT_HAVE_PERMISSION->value,
                ], 422);
            }

            $token = $user->createToken('apiToken')->accessToken;

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::LOGIN_USER_SUCCESS->value,
                'data' => [
                    'user' => new AuthUserResource($user)
                ],
                'token' => $token
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::LOGIN_USER_FAILED->value
            ], 422);
        }
    }
}
