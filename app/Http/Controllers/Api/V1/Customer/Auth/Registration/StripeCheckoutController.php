<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth\Registration;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Auth\AuthUserResource;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        dd(gs()->payment_stripe_secret);
        Stripe::setApiKey(gs()->payment_stripe_secret);

        try {

            $session = Session::retrieve($request->session_id);

            if(!$session) {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            }

            $order = SubscriptionOrder::where('session_id', $session->id)->where('status', 'pending')->first();

            if(!$order) {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            }

            $user = $order->user;
            if($order->status == OrderStatusEnum::PENDING->value) {
                $order->status = OrderStatusEnum::PAID->value;
                $order->save();

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


        } catch(\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
            ], 404);
        }
    }
}
