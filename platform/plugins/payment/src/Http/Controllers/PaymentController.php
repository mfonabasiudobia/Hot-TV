<?php

namespace Botble\Payment\Http\Controllers;

use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Http\Requests\PaymentMethodRequest;
use Botble\Payment\Http\Requests\UpdatePaymentRequest;
use Botble\Payment\Models\Payment;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\Payment\Tables\PaymentTable;
use Botble\Setting\Supports\SettingStore;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function __construct(protected PaymentInterface $paymentRepository)
    {
    }

    public function index(PaymentTable $table)
    {
        PageTitle::setTitle(trans('plugins/payment::payment.name'));

        return $table->renderTable();
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $payment = Payment::query()->findOrFail($id);

            $payment->delete();

            event(new DeletedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function show(int|string $id)
    {
        $payment = Payment::query()->findOrFail($id);

        PageTitle::setTitle(trans('plugins/payment::payment.view_transaction', ['charge_id' => $payment->charge_id]));

        $detail = apply_filters(PAYMENT_FILTER_PAYMENT_INFO_DETAIL, null, $payment);

        $paymentStatuses = PaymentStatusEnum::labels();

        if ($payment->status != PaymentStatusEnum::PENDING) {
            Arr::forget($paymentStatuses, PaymentStatusEnum::PENDING);
        }

        Assets::addScriptsDirectly('vendor/core/plugins/payment/js/payment-detail.js');

        return view('plugins/payment::show', compact('payment', 'detail', 'paymentStatuses'));
    }

    public function methods()
    {
        PageTitle::setTitle(trans('plugins/payment::payment.payment_methods'));

        Assets::addStylesDirectly('vendor/core/plugins/payment/css/payment-methods.css')
            ->addScriptsDirectly('vendor/core/plugins/payment/js/payment-methods.js');

        return view('plugins/payment::settings.index');
    }

    public function updateSettings(Request $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $data = $request->except(['_token']);
        foreach ($data as $settingKey => $settingValue) {
            $settingStore
                ->set($settingKey, $settingValue);
        }

        $settingStore->save();

        return $response->setMessage(trans('plugins/payment::payment.saved_payment_settings_success'));
    }

    public function updateMethods(PaymentMethodRequest $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $type = $request->input('type');
        $data = $request->except(['_token', 'type']);
        Stripe::setApiKey(gs()->payment_stripe_secret);

        if($type === 'stripe' && array_key_exists('payment_stripe_client_id', $data)) {
            if(isset($data['payment_stripe_client_id']) && $settingStore->get('payment_stripe_client_id') !== $data['payment_stripe_client_id']) {
                $products = Product::all();

                foreach ($products->data as $product) {
                    $prices = Price::all(['product' => $product->id]);

                    foreach ($prices->data as $price) {
                        Price::update($price->id, ['active' => false]);
                    }

                    Product::update($product->id, ['active' => false]);
                }

                $subscriptions = Subscription::with('plan')->get();
                foreach($subscriptions as $plan) {
                    $stripeProduct = Product::create([
                        'name' => $plan->name,
                        'active' => true,
                    ]);

                    $stripProductPrice = Price::create([
                        'currency' => 'usd',
                        'unit_amount' => $plan->price * 100,
                        'recurring' =>[ 'interval' =>  $plan->subscription_plan_id == 1 ? 'month' : 'year'],
                        'product' => $stripeProduct->id
                    ]);

                    $plan->stripe_plan_id = $stripProductPrice->id;
                    $plan->save();
                }

                $orders = SubscriptionOrder::where('payment_method_type', 'stripe')
                    ->whereNotNull('stripe_subscription_id')
                    ->get();

                foreach($orders as $order) {
                    $user = $order->user;

                    $stripeCustomer = \Stripe\Customer::create([
                        'email' => $user->email,
                        'name' => $user->name,
                    ]);

                    $user->stripe_customer_id = $stripeCustomer->id;
                    $user->save();


                    if($order->subscription) {
                        $nextBillingDate = strtotime($order->next_billing_date ?? $order->subscription->trial_ended_at ?? now());

                        $stripeSubscription = \Stripe\Subscription::create([
                            'customer' => $user->stripe_customer_id,
                            'items' => [
                                ['price' => $order->subscription->stripe_plan_id],
                            ],
                            'billing_cycle_anchor' => $nextBillingDate,
                            'proration_behavior' => 'none', // Ensures no extra charge for aligning billing cycle
                            'trial_end' => $order->subscription->trial_ended_at ? strtotime($order->subscription->trial_ended_at) : 'now',
                            'payment_behavior' => 'default_incomplete', // Allows subscription creation without immediate payment method
                            'trial_settings' => [
                                'end_behavior' => [
                                    'missing_payment_method' => 'cancel',
                                ],
                            ]
                        ]);

                        $order->stripe_subscription_id = $stripeSubscription->id;
                        $order->recurring_status = $stripeSubscription->status; // Example: active, incomplete, etc.
                        $order->next_billing_date = date('Y-m-d H:i:s', $stripeSubscription->current_period_end);
                        $order->save();
                    }

                }
            }
        }

        if($type === 'paypal' && array_key_exists('payment_paypal_client_id', $data)) {
            if(isset($data['payment_paypal_client_id']) && $settingStore->get('payment_paypal_client_id') !== $data['payment_paypal_client_id']) {
                $provider = new PayPalClient([]);
                $token = $provider->getAccessToken();
                $provider->setAccessToken($token);

                $plans = $subscriptions = Subscription::with('plan')->get();
                foreach($plans as $plan) {
                    $planDetails = $provider->showPlanDetails($plan->paypal_plan_id);

                    $productId = $planDetails['product_id'];
                    $provider->updatePlan($plan->paypal_plan_id, [
                        [
                            'op' => 'replace',
                            'path' => '/status',
                            'value' => 'INACTIVE',
                        ],
                    ]);

                    $provider->updateProduct($productId, [
                        [
                            'op' => 'replace',
                            'path' => '/status',
                            'value' => 'INACTIVE',
                        ],
                    ]);

                    $paypalProduct = $provider->createProduct([
                        'name' => $plan->name,
                        'description' => $plan->name,
                        'type' => 'SERVICE',
                        'category' =>   'SOFTWARE'
                    ]);

                    $paypalProductId = $paypalProduct['id'];

                    $paypalPlan = $provider->createPlan([
                        'product_id' => $paypalProductId,
                        'name' => $plan->name,
                        'description' => $plan->name,
                        'billing_cycles' => [
                            [
                                'frequency' => [
                                    'interval_unit' => $request->input('subscription_plan_id') == 1 ? 'MONTH' : 'YEAR',
                                    'interval_count' => 1,
                                ],
                                'tenure_type' => 'REGULAR',
                                'sequence' => 1,
                                'total_cycles' => 0,
                                'pricing_scheme' => [
                                    'fixed_price' => [
                                        'value' => $plan->price * 100,
                                        'currency_code' => 'USD'
                                    ],
                                ],
                            ],
                        ],
                        'payment_preferences' => [
                            'auto_bill_outstanding' => true,
                            'setup_fee' => [
                                'value' => 0,
                                'currency_code' => 'USD'
                            ],
                            'setup_fee_failure_action' => 'CONTINUE',
                            'payment_failure_threshold' => 3
                        ],
                    ]);

                    $plan->paypal_plan_id = $paypalPlan['id'];
                    $plan->save();
                }
            }
        }

        foreach ($data as $settingKey => $settingValue) {
            $settingStore
                ->set($settingKey, $settingValue);
        }

        $settingStore
            ->set('payment_' . $type . '_status', 1)
            ->save();

        return $response->setMessage(trans('plugins/payment::payment.saved_payment_method_success'));
    }

    public function updateMethodStatus(Request $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $settingStore
            ->set('payment_' . $request->input('type') . '_status', 0)
            ->save();

        return $response->setMessage(trans('plugins/payment::payment.turn_off_success'));
    }

    public function update(int|string $id, UpdatePaymentRequest $request, BaseHttpResponse $response)
    {
        $payment = Payment::query()->findOrFail($id);

        $this->paymentRepository->update(['id' => $payment->id], [
            'status' => $request->input('status'),
        ]);

        do_action(ACTION_AFTER_UPDATE_PAYMENT, $request, $payment);

        return $response
            ->setPreviousUrl(route('payment.show', $payment->id))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function getRefundDetail(int|string $id, int|string $refundId, BaseHttpResponse $response)
    {
        $data = [];
        $payment = Payment::query()->findOrFail($id);

        $data = apply_filters(PAYMENT_FILTER_GET_REFUND_DETAIL, $data, $payment, $refundId);

        if (! Arr::get($data, 'error') && Arr::get($data, 'data', [])) {
            $metadata = $payment->metadata;
            $refunds = Arr::get($metadata, 'refunds', []);
            if ($refunds) {
                foreach ($refunds as $key => $refund) {
                    if (Arr::get($refund, '_refund_id') == $refundId) {
                        $refunds[$key] = array_merge($refunds[$key], (array) Arr::get($data, 'data'));
                    }
                }

                Arr::set($metadata, 'refunds', $refunds);
                $payment->metadata = $metadata;
                $payment->save();
            }
        }

        $view = Arr::get($data, 'view');

        if ($view) {
            $response->setData($view);
        }

        return $response
            ->setError((bool) Arr::get($data, 'error'))
            ->setMessage(Arr::get($data, 'message', ''));
    }
}
