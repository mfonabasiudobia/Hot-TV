<?php

namespace App\Http\Livewire\Cart;

use App\Payment\Enums\StatusEnum;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Livewire\Component;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Cart as CartLibrary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaypalPaymentVerification extends Component
{

    public $subTotal;
    public $taxAmount;
    public $discountAmount;
    public $totalAmount;

    public function mount()
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

            $this->subTotal = sub_total();
            $this->totalAmount = total_amount();
            $this->taxAmount = tax_amount();
            $this->discountAmount = discount_amount();

            foreach (CartLibrary::instance('product')->content() as $content) {
                CartLibrary::instance('product')->remove($content->rowId);
            }
        }
    }

    public function render()
    {
        return view('livewire.order-completed');
    }
}
