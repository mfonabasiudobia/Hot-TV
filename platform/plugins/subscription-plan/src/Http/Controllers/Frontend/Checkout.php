<?php
namespace Botble\SubscriptionPlan\Http\Controllers\Frontend;

use Botble\SubscriptionPlan\Http\Livewire\BaseComponent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Enums\ShippingCodStatusEnum;
use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Ecommerce\Enums\ShippingStatusEnum;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Checkout extends BaseController 
{
    
    public function checkoutSubmit(Request $request)
    {
        $stripePlanId = $request->input('stripe_plan_id');
        $email = $request->input('email');

        Stripe::setApiKey(gs()->payment_stripe_secret);
        // try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $stripePlanId,
                        'quantity' => 1,
                    ],
                ],
                'customer_email' => $email,
                'mode' => 'subscription',
                'success_url' => 'http://localhost/payment-verification?session_id={CHECKOUT_SESSION_ID}',//route('payment-verification', ['order' => $order->id]),
                //'cancel_url' => 'http://localhost/cancel',//route('checkout'),
            ]);

            $order = [
                'amount' => $session->amount_subtotal/100,
                'user_id' => auth()->user()->id,
                'session_id' => $session->id,
                'sub_total' => $session->amount_subtotal/100,
                'status' => 'pending',
                ];
    
            $order = SubscriptionOrder::create($order);
            
            return redirect($session->url);
        // } catch (\Throwable $e) {
        //     return toast()->danger($e->getMessage())->push();
        // }
    }

    public function paymentVerification(Request $request)
    {
        
        Stripe::setApiKey(gs()->payment_stripe_secret);
        
        try {
            $session = Session::retrieve($request->session_id);
            
            if(!$session) {
                throw new NotFoundHttpException();
            }
            $order = SubscriptionOrder::where('session_id', $session->id)->where('status', 'pending')->first();
            
            if(!$order) {
                
                throw new NotFoundHttpException();
            }

            
            if($order->status == 'pending') {
                
                $order->status = 'paid';
                $order->save();
            }

            return redirect('/');
        
        } catch(\Exception $e) {
            throw new NotFoundHttpException();
        }

        
    }
}
