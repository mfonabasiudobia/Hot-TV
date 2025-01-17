<?php
namespace Botble\SubscriptionPlan\Http\Controllers\Frontend;

use App\Enums\User\StatusEnum;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\AuthRepository;
use Botble\SubscriptionPlan\Http\Livewire\BaseComponent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Http\Controllers\BaseController;
//use Botble\Ecommerce\Models\Order;
//use Botble\Ecommerce\Enums\OrderStatusEnum;
//use Botble\Ecommerce\Enums\ShippingCodStatusEnum;
//use Botble\Ecommerce\Enums\ShippingMethodEnum;
//use Botble\Ecommerce\Enums\ShippingStatusEnum;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Stripe\Subscription;

class Checkout extends BaseController
{
    public function checkoutSubmit(RegistrationRequest $request)
    {


        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $stripePlanId = $request->input('stripe_plan_id');
        $subscriptionId = $request->input('subscription_id');

        Stripe::setApiKey(gs()->payment_stripe_secret);

        // try {

            $customer = Customer::create([
                'email' => $email,
                'name' => "$firstName $lastName"

            ]);
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $stripePlanId,
                        'quantity' => 1,
                    ],
                ],
                'customer' => $customer->id,
                'mode' => 'subscription',
                'success_url' => config('app.redirect_success_url'), //http://localhost/payment-verification?session_id={CHECKOUT_SESSION_ID}',//route('payment-verification', ['order' => $order->id]),
                //'cancel_url' => 'http://localhost/cancel',//route('checkout'),
            ]);



            $user = AuthRepository::register([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'status' => StatusEnum::LOCKED->value
            ]);

            $order = [
                'amount' => $session->amount_subtotal/100,

                'subscription_id' => $subscriptionId,
                'user_id' => $user->id,
                'payment_method_type' => 'stripe',
                'session_id' => $session->id,
                'sub_total' => $session->amount_subtotal/100,
            ];
            $order = SubscriptionOrder::create($order);

            return redirect($session->url);
        // } catch (\Throwable $e) {
        //     return toast()->danger($e->getMessage())->push();
        // }
    }

    public function stripePaymentVerification($sessionId)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        try {
            $session = Session::retrieve($sessionId);
            $stripeSubscription = Subscription::retrieve($session->subscription);
            $nextBillingDate = $stripeSubscription && $stripeSubscription->current_period_end ? date('Y-m-d H:i:s', $stripeSubscription->current_period_end) : null;

            if(!$session) {
                throw new NotFoundHttpException();
            }
            $order = SubscriptionOrder::where('session_id', $session->id)
                ->where(function($query) {
                    return $query->where('status', OrderStatusEnum::PENDING->value)
                        ->orWhere('status', OrderStatusEnum::TRAIL->value)
                        ->orWhere('status', OrderStatusEnum::PAID->value)  ;
                })
                ->where('current_subscription', true)
                ->first();

            if(!$order) {
                throw new NotFoundHttpException();
            }

            if($order->status == OrderStatusEnum::PENDING->value || $order->status == OrderStatusEnum::PAID->value) {
                $order->status = OrderStatusEnum::PAID->value;
                $order->stripe_subscription_id = $session->subscription;
                $order->next_billing_date = $nextBillingDate;
                $order->save();
            }

            $user = $order->user;
            $user->status = StatusEnum::ACTIVATED->value;
            $user->save();

            session()->flash('confirmation-email-message', true);

            return redirect()->route("login");

        } catch(\Exception $e) {

            throw new NotFoundHttpException();
        }
    }

    public function paypalPaymentVerification(Request $request)
    {
        $sessionId = $request->subscription_id;

        $order = SubscriptionOrder::where('session_id', $sessionId)
            ->where(function($query) {
                return $query->where('status', OrderStatusEnum::PENDING->value)
                    ->orWhere('status', OrderStatusEnum::TRAIL->value)  ;
            })
            ->where('current_subscription', true)
            ->first();
        if(!$order) {
            throw new NotFoundHttpException();
        }

        if($order->status == OrderStatusEnum::PENDING->value) {
            $order->status = OrderStatusEnum::PAID->value;
            $order->paypal_subscription_id = $sessionId;
            $order->save();


        }
        $user = $order->user;
        $user->status = StatusEnum::ACTIVATED->value;
        $user->save();

        session()->flash('confirmation-email-message', true);
        return redirect()->route("login");
    }

    public function paypalPaymentCancel(Request $request)
    {
        $sessionId = $request->subscription_id;

        $order = SubscriptionOrder::where('session_id', $sessionId)->where('status', 'pending')->first();

        if($order) {
            $order->status = OrderStatusEnum::FAILED->value;
            $order->save();
        }

        session()->flash('payment-failed', true);
        return redirect()->route("login");
    }
}
