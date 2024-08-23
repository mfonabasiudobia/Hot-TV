<?php

namespace App\Http\Livewire\Auth;

use App\Enums\User\StatusEnum;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Illuminate\Http\Request;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubscriptionCheckoutVerification extends Component
{

    public function mount($sessionId)
    {
        dd($sessionId);
        Stripe::setApiKey(gs()->payment_stripe_secret);

        try {
            $session = Session::retrieve($sessionId);


            if(!$session) {
                throw new NotFoundHttpException();
            }

            $order = SubscriptionOrder::where('session_id', $session->id)->where('status', 'pending')->first();

            if(!$order) {
                throw new NotFoundHttpException();
            }

            if($order->status == OrderStatusEnum::PENDING->value) {
                $order->status = OrderStatusEnum::PAID->value;
                $order->save();

                $user = $order->user;
                $user->status = StatusEnum::ACTIVATED->value;
                $user->save();
            }

            session()->flash('confirmation-email-message', true);

            return redirect()->route("login");

        } catch(\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

}
