<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Auth\AuthUserResource;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::USER_PROFILE->value,
            'data' => new AuthUserResource($user)
        ]);
    }
}
