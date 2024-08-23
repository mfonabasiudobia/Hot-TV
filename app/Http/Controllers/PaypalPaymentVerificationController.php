<?php

namespace App\Http\Controllers;

use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Cart as CartLibrary;

class PaypalPaymentVerificationController extends Controller
{
    public function cancel(Request $request)
    {

    }

    public function paymentSuccess(Request $request)
    {

        $token = $request['token'];
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $session = $provider->capturePaymentOrder($token);

        if(!$session) {
            throw new NotFoundHttpException();
        }

        $payment = Payment::where('charge_id',  $session['id'])->where('status', 'pending')->first();

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
