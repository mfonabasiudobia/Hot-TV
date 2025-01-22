<?php

namespace App\Http\Controllers;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Events\RidePaymentSucceeded;
use App\Http\Controllers\Controller;
use App\Payment\Enums\StatusEnum;
use Botble\ACL\Models\User;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Gloudemans\Shoppingcart\Facades\Cart as CartLibrary;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripePaymentVerificationController extends Controller
{
    public function __invoke($sessionId)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        $session = Session::retrieve($sessionId);
        if(!$session) {
            throw new NotFoundHttpException();
        }

        $ride = \App\Models\Ride::where('id', $session->metadata->ride_id)->first();
        \Log::info('Ride not found using payment intent id', [$ride]);
        if($ride) {
            $ride->payment_status = 'paid';
            $ride->save();
            event(new RidePaymentSucceeded($ride));
        }else{
            \Log::info('Ride not found using payment intent id', [$session->id]);
        }

    }
}
