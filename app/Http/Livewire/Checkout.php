<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use Botble\Ecommerce\Models\OrderAddress;
use Botble\Ecommerce\Models\Address;
use Botble\Ecommerce\Models\Order;
use Cart;
use Botble\Payment\Facades\PaymentMethods;

use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Models\Payment;
use Botble\Payment\Supports\PaymentHelper;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

use Omnipay\Omnipay;

class Checkout extends BaseComponent
{

    public $first_name, $last_name, $email, $mobile_number, $address, $country, $post_code, $city;

    public $can_save = 1, $payment_method;

    public function mount(){
        if(Cart::instance('product')->count() === 0){

            toast()->danger('Cart cannot be empty')->pushOnNextPage();

            return redirect()->route('cart');
        }

        $this->fill([
            // 'first_name' => 'MfonAbasi',
            // 'last_name' => 'Udobia',
            // 'email' => 'mfonabasiisaac@gmail.com',
            // 'mobile_number' => '09036342948',
            // 'address' => 'No 3, Ekpri Close, Uyo',
            // 'country' => 'Nigeria',
            // 'post_code' => 37382,
            // 'city' => 'Uyo',
            'payment_method' => gs()->default_payment_method
        ]);
        
    }

     public function submit(){

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'address' => 'required',
            'country' => 'required',
            'post_code' => 'required',
            'city' => 'required',
            'email' => 'required'
        ]);


        Stripe::setApiKey(gs()->payment_stripe_secret);

        try {
            
            if($this->can_save){
                Address::create([
                    'name' => "{$this->first_name} {$this->last_name}",
                    'phone' => $this->mobile_number,
                    'address' => $this->address,
                    'email' => $this->email,
                    'customer_id' => auth()->id() ?? 0,
                    'country' => $this->country,
                    'city' => $this->city,
                    'zip_code' => $this->post_code
                ]);
            }

            $order = Order::create([
                'user_id' => auth()->id() ?? 0,
                'amount' => total_amount(),
                'tax_amount' => tax_amount(),
                'sub_total' => sub_total(),
                'discount_amount' => discount_amount(),
            ]);

            OrderAddress::create([
                'name' => "{$this->first_name} {$this->last_name}",
                'phone' => $this->mobile_number,
                'address' => $this->address,
                'email' => $this->email,
                'order_id' => $order->id,
                'country' => $this->country,
                'city' => $this->city,
                'zip_code' => $this->post_code
            ]);

            if($this->payment_method === 'stripe'){

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
                                    'unit_amount' => total_amount()*100, // Amount in cents
                                ],
                                'quantity' => 1,
                            ],
                        ],
                        'mode' => 'payment',
                        'success_url' =>route('payment-verification', ['order' => $order->id]),
                        'cancel_url' => route('checkout'),
                    ]);

                    return redirect($session->url);

                // return redirect()->route('payment-verification');

                

            }else{

                $gateway = Omnipay::create("PayPal_Rest");
                $gateway->setClientId(env('PAYPAL_CLIENT_ID'));
                $gateway->setSecret(env('PAYPAL_SECRET_ID'));
                $gateway->setTestMode(true);
                
                $response = $gateway->purchase([
                    'amount' =>  total_amount(),
                    'currency' => 'USD',
                    'returnUrl' => route('payment-verification', ['order' => $order->id]),
                    'cancelUrl' => route('checkout'),
                ])->send();

                if($response->isRedirect()){
                    redirect($response->getRedirectUrl());
                }else{
                    dd("Not Working");
                }
            }

        //   Cart::instance('product')->destroy();         

        } catch (\Throwable $e) {
            return toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.checkout');
    }
}
