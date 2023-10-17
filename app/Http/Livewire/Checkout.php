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

class Checkout extends BaseComponent
{

    public $first_name, $last_name, $email, $mobile_number, $address, $country, $post_code, $city;

    public $can_save = 1;

    public function mount(){
        // dd(PaymentHelper::defaultPaymentMethod());
        // dd(PaymentMethodEnum::labels());
        // dd(PaymentMethodEnum::getLabel('Stripe'));
        // dd(PaymentMethodEnum::labels());

        // dd(PaymentMethodEnum::STRIPE);

        if(Cart::instance('product')->count() === 0){

            toast()->danger('Cart cannot be empty')->pushOnNextPage();

            return redirect()->route('cart');
        }

        // $this->fill([
        //     'first_name' => 'MfonAbasi',
        //     'last_name' => 'Udobia',
        //     'email' => 'mfonabasiisaac@gmail.com',
        //     'mobile_number' => '09036342948',
        //     'address' => 'No 3, Ekpri Close, Uyo',
        //     'country' => 'Nigeria',
        //     'post_code' => 37382,
        //     'city' => 'Uyo'
        // ]);
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

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 1000, // Replace with the actual amount in cents
            'currency' => 'usd',
        ]);

        dd($paymentIntent);

        return redirect()->to($paymentIntent->next_action->redirect_to_url->url);

        // Stripe::setApiKey(gs()->payment_stripe_secret);

        // // Create a Stripe Session for payment
        // $session = Session::create([
        //     'payment_method_types' => ['card'],
        //     'line_items' => [
        //         [
        //             'price_data' => [
        //                 'currency' => 'usd',
        //                 'product_data' => [
        //                     'name' => 'Payment for Products',
        //                 ],
        //                 'unit_amount' => total_amount()*100, // Amount in cents
        //             ],
        //             'quantity' => 1,
        //         ],
        //     ],
        //     'mode' => 'payment',
        //     'success_url' => route('payment-verification'),
        //     'cancel_url' => route('checkout'),
        // ]);

        // return redirect($session->url);




        try {
            
            if($this->can_save){
                Address::create([
                    'name' => "{$this->first_name} {$this->last_name}",
                    'phone' => $this->mobile_number,
                    'address' => $this->address,
                    'email' => $this->email,
                    'customer_id' => auth()->id(),
                    'country' => $this->country,
                    'city' => $this->city,
                    'zip_code' => $this->post_code
                ]);
            }

            $order = Order::create([
                'user_id' => auth()->id(),
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

            // throw_unless(), "Failed to create shipping address");

            Cart::instance('product')->destroy();

            return redirect()->route('payment-verification');

        } catch (\Throwable $e) {
            return toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.checkout');
    }
}
