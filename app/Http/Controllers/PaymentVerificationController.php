<?php

namespace App\Http\Controllers;


use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Cart as CartLibrary;

class PaymentVerificationController extends Controller
{
    public function __invoke(Request $request)
    {

        $sessionId = $request->get('session_id');


        $payload = request()->getContent();
        $sigHeader = request()->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret'); // Your webhook secret from Stripe
        Stripe::setApiKey(gs()->payment_stripe_secret);
        //try {


            $session = Session::retrieve($sessionId);

            if(!$session) {
                throw new NotFoundHttpException();
            }
            //$event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            $payment = Payment::where('charge_id', $session->id)->where('status', 'pending')->first();

            if($payment->status == 'pending') {
                $payment->status = 'completed';
                $payment->save();

                $order = Order::where('id', $payment->order_id)->first();
                $order->is_confirmed = 1;
                $order->is_finished = 1;
                $order->status = 'completed';
                $order->completed_at = now();
            }

            foreach(CartLibrary::instance('product')->content() as $content) {
                CartLibrary::instance('product')->remove($content->rowId);
            }

            return redirect()->route('cart.order-completed');
    }
}
