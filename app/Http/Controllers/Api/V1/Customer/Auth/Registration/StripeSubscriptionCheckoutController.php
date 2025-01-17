<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth\Registration;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use Botble\ACL\Models\User;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeSubscriptionCheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'payment_method' => 'required|in:paypal,stripe',
                'plan_id'   =>  'required'
            ]);

            Stripe::setApiKey(gs()->payment_stripe_secret);

            $user = User::where('email', $request->email)->first();
            if(!$user) {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::NOT_FOUND->value,
                ], 404);
            }

            $subscription = Subscription::where('id', $request->plan_id)->first();

            if(!$subscription) {
                return response()->json([
                    'success'   => false,
                    'message'   => ApiResponseMessageEnum::ORDER_NOT_FOUND->value,
                ], 404);
            }

            if($request->payment_method === 'stripe') {
                $subscriptionStatus = OrderStatusEnum::PENDING->value;

                $stripSessionObject['payment_method_types'] = ['card'];
                $stripSessionObject['line_items'] = [['price' => $subscription->stripe_plan_id,'quantity' => 1,],];
                $stripSessionObject['customer'] = $user->stripe_customer_id;
                $stripSessionObject['mode'] = 'subscription';
                $stripSessionObject['success_url'] = config('app.url'). 'plan/stripe/payment-verification/{CHECKOUT_SESSION_ID}';

                $session = Session::create([
                    $stripSessionObject
                ]);

                $order = SubscriptionOrder::where('user_id', $user->id)->first();
                if(! $order) {
                    $order = [
                        'amount' => $session->amount_subtotal/100,
                        'subscription_id' => $subscription->id,
                        'user_id' => $user->id,
                        'payment_method_type' => $request->payment_method,
                        'session_id' => $session->id,
                        'sub_total' => $session->amount_subtotal/100,
                        'status' => $subscriptionStatus
                    ];
                    $order = SubscriptionOrder::create($order);
                }else{
                    $order->status = $subscriptionStatus;
                    $order->session_id = $session->id;
                    $order->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => ApiResponseMessageEnum::LOGIN_USER_SUCCESS->value,
                    'data' => [
                        'stripe_payment_url' => $session->url
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::LOGIN_USER_SUCCESS->value,
                'data' => [
                    'stripe_payment_url' => 'Paypal URL'
                ]
            ]);

        } catch(\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => ApiResponseMessageEnum::SERVER_ERROR->value,
                'data' => $e->getMessage()
            ], 404);
        }
    }
}
