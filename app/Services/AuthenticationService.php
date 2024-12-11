<?php

namespace App\Services;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Enums\User\StatusEnum;
use App\Repositories\AuthRepository;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class AuthenticationService
{
    public function register(array $data)
    {
        $paymentMethod = $data('payment_method');

        if($paymentMethod == 'stripe' && gs()->payment_stripe_status == 0) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::REGISTRATION_CLOSED->value
            ], 404);
        }

        if($paymentMethod == 'paypal' && gs()->payment_paypal_status == 0) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::REGISTRATION_CLOSED->value
            ], 404);
        }

        $firstName = $data('first_name');
        $lastName = $data('last_name');
        $email = $data('email');
        $username = $data('username');
        $password = $data('password');
        $subscriptionId = $data('subscription_id');


        $subscription = Subscription::where('id', $subscriptionId)->first();

        if(!$subscription) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::SUBSCRIPTION_NOT_FOUND->value
            ], 404);
        }

        if($paymentMethod == 'stripe') {
            $stripePlanId = $subscription->stripe_plan_id;

            Stripe::setApiKey(gs()->payment_stripe_secret);

            $customer = Customer::create([
                'email' => $email,
                'name' => "$firstName $lastName"

            ]);

            $user = AuthRepository::register([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'status' => StatusEnum::LOCKED->value,
                'stripe_customer_id' => $customer->id,
            ]);
            if($subscription->plan->trail == 1) {
                $stripSessionObject['subscription_data'] =['trial_period_days' => $subscription->plan->trail_period_stripe];
                $subscriptionStatus = OrderStatusEnum::TRAIL->value;
            } else {
                $subscriptionStatus = OrderStatusEnum::PENDING->value;
            }

            $stripSessionObject['payment_method_types'] = ['card'];
            $stripSessionObject['line_items'] = [['price' => $stripePlanId,'quantity' => 1,],];
            $stripSessionObject['customer'] = $customer->id;
            $stripSessionObject['mode'] = 'subscription';
            $stripSessionObject['success_url'] = config('app.redirect_success_api_url');
            //$stripSessionObject['cancel_url'] = 'http://localhost/cancel',//route('checkout'),


            $session = Session::create([
                $stripSessionObject
            ]);


            $order = [
                'amount' => $session->amount_subtotal/100,
                'subscription_id' => $subscriptionId,
                'user_id' => $user->id,
                'payment_method_type' => 'stripe',
                'session_id' => $session->id,
                'sub_total' => $session->amount_subtotal/100,
                'status' => $subscriptionStatus
            ];
            $order = SubscriptionOrder::create($order);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::REGISTRATION_PROCESS->value,
                'data' => [
                    'stripe_payment_url' => $session->url
                ]
            ]);
        } else {

            $provider = new PayPalClient([]);
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $user = AuthRepository::register([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'status' => StatusEnum::LOCKED->value,
                //'stripe_customer_id' => $customer->id,
            ]);

            if($subscription->plan->trail == 1) {

                $paypalPlanId = $subscription->paypal_plan_id[$subscription->plan->trail_period_paypal];
            } else {
                $paypalPlanId = $subscription->paypal_plan_id['without_trail'];
            }
            $paypalSubscription = $provider->createSubscription([
                'plan_id' => $paypalPlanId,
                'subscriber' => [
                    'name' => [
                        'given_name' => $firstName,
                        'surname' => $lastName,
                    ],
                    'email_address' => $email,
                ],
                'application_context' => [
                    'brand_name' => 'Hot TV',
                    'locale' => 'en-US',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'payment_method' => [
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                    ],
                    'return_url' => route('paypal-checkout'),
                    //'cancel_url' => route('plan.paypal.payment-cancel'),
                ],
            ]);

            $order = [
                'amount' => $subscription->price,
                'subscription_id' => $subscription->id,
                'user_id' => $user->id,
                'payment_method_type' => 'paypal',
                'session_id' => $paypalSubscription['id'],
                'sub_total' => $subscription->price,
            ];
            $order = SubscriptionOrder::create($order);

            $approvalUrl = $paypalSubscription['links'][0]['href'];

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::REGISTRATION_PROCESS->value,
                'data' => [
                    'stripe_payment_url' => $approvalUrl
                ]
            ]);
        }
    }
}
