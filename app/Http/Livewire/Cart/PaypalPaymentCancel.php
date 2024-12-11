<?php

namespace App\Http\Livewire\Cart;

use App\Payment\Enums\StatusEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Payment\Models\Payment;
use Livewire\Component;

class PaypalPaymentCancel extends Component
{

    public function mount()
    {
        $token = request()['token'];

        $payment = Payment::where('charge_id', $token)->where('status', StatusEnum::PENDING->value)->first();

        if($payment) {
            $payment->status = StatusEnum::FAILED->value;
            $payment->save();

            $order = Order::where('id', $payment->order_id)->first();

            $order->status = StatusEnum::CANCELED->value;
            $order->save();
        }
    }

    public function render()
    {
        return view('livewire.cart.order-canceled');
    }
}
