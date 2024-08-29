<?php

namespace App\Http\Controllers\Api\V1\Customer\Ecommerce\Checkout;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Payment\Enums\StatusEnum;
use Botble\ACL\Models\User;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Gloudemans\Shoppingcart\Facades\Cart as CartLibrary;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaypalPaymentVerificationController extends Controller
{
    public function __invoke()
    {
        $token = request()['token'];

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $session = $provider->capturePaymentOrder($token);

        if(isset($session['error'])) {
            throw new NotFoundHttpException();
        }

        $payment = Payment::where('charge_id', $session['id'])->where('status', StatusEnum::PENDING->value)->first();
        if(!$payment) {
            throw new NotFoundHttpException();
        } else {

            $payment->status = StatusEnum::COMPLETED->value;
            $payment->save();
            $order = Order::where('id', $payment->order_id)->first();
            $order->is_confirmed = 1;
            $order->is_finished = 1;
            $order->status = StatusEnum::COMPLETED->value;
            $order->completed_at = now();
            $order->save();

            $user = User::where('id', $order->user_id)->first();
            CartLibrary::instance('product')->restore($user->id . '_' . $user->username);
            foreach (CartLibrary::instance('product')->content() as $content) {
                CartLibrary::instance('product')->remove($content->rowId);
            }
            CartLibrary::instance('product')->store($user->id . '_' . $user->username);

            return response()->json([
                'success' => true,
                'message' => ApiResponseMessageEnum::PAYMENT_SUCCESS->value,
            ]);
        }
    }
}
