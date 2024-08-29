<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Checkout;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Customer\Ecommerce\Checkout\CheckoutRequest;
use Botble\Ecommerce\Models\Address;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Botble\Ecommerce\Models\OrderAddress;
use Gloudemans\Shoppingcart\Facades\Cart as CartLibrary;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request)
    {

        $user = Auth::user();
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $mobileNumber = $request->input('mobile_number');
        $address = $request->input('address');
        $country = $request->input('country');
        $postCode = $request->input('post_code');
        $city = $request->input('city');
        $email = $request->input('email');
        $paymentMethod = $request->input('payment_method');
        $saveShipping = $request->input('save_shipping');

        CartLibrary::instance('product')->restore($user->id . '_' . $user->username);
        $cart = CartLibrary::instance('product')->content();

        if($saveShipping){
            Address::create([
                'name' => "{$firstName} {$lastName}",
                'phone' => $mobileNumber,
                'address' => $address,
                'email' => $email,
                'customer_id' => $user->id,
                'country' => $country,
                'city' => $city,
                'zip_code' => $postCode
            ]);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'amount' => CartLibrary::total(),
            'tax_amount' => CartLibrary::tax(),
            'sub_total' => getSubTotal($cart),
            'discount_amount' => calculateDiscount($cart),
        ]);
        OrderAddress::create([
            'name' => "{$firstName} {$lastName}",
            'phone' => $mobileNumber,
            'address' => $address,
            'email' => $email,
            'order_id' => $order->id,
            'country' => $country,
            'city' => $city,
            'zip_code' => $postCode
        ]);


        if($paymentMethod === 'stripe'){
            Stripe::setApiKey(gs()->payment_stripe_secret);
            // // Create a Stripe Session for payment
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Payment for Products',
                            ],
                            'unit_amount' => CartLibrary::total() * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => url('api/v1/customer/ecommerce/stripe/payment-success/{CHECKOUT_SESSION_ID}'),
                'cancel_url' => route('cart.checkout'),
            ]);

            $payment = Payment::create([
                'currency' => 'USD',
                'user_id' => auth()->id() ?? 0,
                'charge_id' => $session->id,
                'payment_channel' => 'stripe',
                'amount' => CartLibrary::total(),
                'order_id' => $order->id,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::STRIPE_PAYMENT_URL->value,
                'data' => [
                    'url' => $session->url
                ]
            ]);
            // return redirect()->route('payment-verification');
        } else{

            $provider = new PayPalClient([]);
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $data = [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => CartLibrary::total()
                        ]
                    ]
                ],
                "application_context" => [
                    "cancel_url" => route('v1.customer.ecommerce.paypal.payment.cancel'),
                    "return_url" => route('v1.customer.ecommerce.paypal.payment.success'),
                ]
            ];
            $session = $provider->createOrder($data);


            $payment = Payment::create([
                'currency' => 'USD',
                'user_id' => auth()->id() ?? 0,
                'charge_id' => $session['id'],
                'payment_channel' => 'paypal',
                'amount' => CartLibrary::total(),
                'order_id' => $order->id,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::PAYPAL_PAYMENT_URL->value,
                'data' => [
                    'url' => $session['links'][1]['href']
                ]
            ]);
            //return redirect($session['links'][1]['href']);

        }
    }
}
