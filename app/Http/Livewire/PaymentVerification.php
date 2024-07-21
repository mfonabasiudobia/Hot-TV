<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Botble\Ecommerce\Models\Order;


class PaymentVerification extends BaseComponent
{

    public $order;

    public function mount(){
        $this->order = request()->query('order');

        $payload = request()->getContent();
        $sigHeader = request()->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret'); // Your webhook secret from Stripe

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            dd($event);

            // Handle specific events
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    // Payment succeeded, update your database or perform necessary actions
                    break;

                case 'payment_intent.payment_failed':
                    // Payment failed, handle accordingly
                    break;

                // Add more cases for other events as needed

                default:
                    // Unexpected event type
                    break;
            }

            return response()->json(['status' => 'success']);
        } catch (SignatureVerificationException $e) {
            return response()->json(['status' => 'Webhook signature verification failed'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['status' => 'success']);
    }

    public function render()
    {
        if($this->order){
            $order=Order::find($this->order);
            $order->status='processing';
            $order->is_confirmed=1;
            $order->is_finished=1;
            $order->payment_id=7;
            $order->save();
        }
        return view('livewire.payment-verification');
    }
}
