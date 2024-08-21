<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth\Registration;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Auth\RegistrationRequest;
use App\Repositories\AuthRepository;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request)
    {
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $subscriptionId = $request->input('subscription_id');

        $subscription = Subscription::where('id', $subscriptionId)->first();
        if(!$subscription) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SUBSCRIPTION_NOT_FOUND->value
            ], 404);
        }
        $stripePlanId = $subscription->stripe_plan_id;

        Stripe::setApiKey(gs()->payment_stripe_secret);

        $customer = Customer::create([
            'email' => $email,
            'name' => "$firstName $lastName"

        ]);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $stripePlanId,
                    'quantity' => 1,
                ],
            ],
            'customer' => $customer->id,
            'mode' => 'subscription',
            'success_url' => config('app.redirect_success_api_url'), //http://localhost/payment-verification?session_id={CHECKOUT_SESSION_ID}',//route('payment-verification', ['order' => $order->id]),
            //'cancel_url' => 'http://localhost/cancel',//route('checkout'),
        ]);

        $user = AuthRepository::registerAsSubscriber([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'status' => StatusEnum::LOCKED->value
        ]);

        $order = [
            'amount' => $session->amount_subtotal/100,

            'subscription_id' => $subscriptionId,
            'user_id' => $user->id,
            'payment_method_type' => 'stripe',
            'session_id' => $session->id,
            'sub_total' => $session->amount_subtotal/100,
        ];
        $order = SubscriptionOrder::create($order);

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::REGISTRATION_PROCESS->value,
            'data' => [
                'stripe_payment_url' => $session->url
            ]
        ]);
    }
}
