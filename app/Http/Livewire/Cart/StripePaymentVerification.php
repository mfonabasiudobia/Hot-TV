<?php

namespace App\Http\Livewire\Cart;

use App\Payment\Enums\StatusEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Cart as CartLibrary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripePaymentVerification extends Component
{
    public $subTotal;
    public $taxAmount;
    public $discountAmount;
    public $totalAmount;
    public function mount($sessionId)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        $session = Session::retrieve($sessionId);
        if(!$session) {
            throw new NotFoundHttpException();
        }

        $payment = Payment::where('charge_id', $session->id)->where('status', StatusEnum::PENDING->value)->first();
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
