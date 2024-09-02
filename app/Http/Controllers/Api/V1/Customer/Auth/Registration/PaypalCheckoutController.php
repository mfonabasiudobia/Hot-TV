<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth\Registration;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Http\Resources\Api\V1\Customer\Auth\AuthUserResource;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaypalCheckoutController extends Controller
{
    public function __invoke(Request $request)
    {

        $sessionId = $request->subscription_id;

        $order = SubscriptionOrder::where('session_id', $sessionId)->where('status', 'pending')->first();
        if(!$order) {
            return response()->json([
                'success'   => false,
                'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
            ], 404);
        }

        if($order->status == OrderStatusEnum::PENDING->value) {
            $order->status = OrderStatusEnum::PAID->value;
            $order->save();

            $user = $order->user;
            $user->status = StatusEnum::ACTIVATED->value;
            $user->save();
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
    }
}
