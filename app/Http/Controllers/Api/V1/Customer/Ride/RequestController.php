<?php

namespace App\Http\Controllers\Api\V1\Customer\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ride\Request;
use App\Models\Ride;
use App\Models\RideBooking;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class RequestController extends Controller
{
    public function __invoke(Request $request)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        $user = Auth::user();
        $rideId = $request->input('ride_id');
        $paymentMethod = $request->input('payment_method');

        $ride = Ride::find($rideId);
        if(!$ride) {
            return response()->json([
                'success' => false,
                'message' => ApiResponseMessageEnum::NO_RIDE_FOUND->value
            ], 404);
        }

        $rideBooking = $user->rideBookings()->create([
            'ride_id' => $rideId
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'amount' => $ride->price,
            'tax_amount' => 0,
            'sub_total' => $ride->price,
            'discount_amount' => 0,
        ]);

        if($paymentMethod === 'stripe'){

            // // Create a Stripe Session for payment
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Payment for Pedicab Ride',
                            ],
                            'unit_amount' => $ride->price * 100, // Amount in cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => url('api/v1/customer/ride/stripe/payment-verification?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => route('api.v1.customer.ride.stripe.payment-cancel'),
            ]);

            $payment = Payment::create([
                'currency' => 'USD',
                'user_id' => auth()->id(),
                'charge_id' => $session->id,
                'payment_channel' => 'stripe',
                'amount' => $ride->price,
                'order_id' => $order->id,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STRIPE_PAYMENT_URL->value,
                'data' => $session->url
                ]);

            // return redirect()->route('payment-verification');
        }else{

            $provider = new PayPalClient([]);
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $data = [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $ride->price
                        ]
                    ]
                ],
                "application_context" => [
                    "cancel_url" => route('api.v1.customer.ride.paypal.payment-cancel'),
                    "return_url" => route('api.v1.customer.ride.paypal.payment-verification'),
                ]
            ];
            $session = $provider->createOrder($data);


            $payment = Payment::create([
                'currency' => 'USD',
                'user_id' => auth()->id(),
                'charge_id' => $session['id'],
                'payment_channel' => 'paypal',
                'amount' => $ride->price,
                'order_id' => $order->id,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STRIPE_PAYMENT_URL->value,
                'data' => $session['links'][1]['href']
            ]);
        }
    }
}
