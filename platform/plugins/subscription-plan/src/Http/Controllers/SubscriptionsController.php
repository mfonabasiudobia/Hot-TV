<?php

namespace Botble\SubscriptionPlan\Http\Controllers;

use Botble\SubscriptionPlan\Http\Requests\SubscritionsRequest;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\SubscriptionPlan\Tables\SubscritionsTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SubscriptionPlan\Forms\SubscritionsForm;
use Botble\Base\Forms\FormBuilder;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;


class SubscriptionsController extends BaseController
{
    public function index(SubscritionsTable $table)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscritions.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscritions.create'));

        return $formBuilder->create(SubscritionsForm::class)->renderForm();
    }

    public function store(SubscritionsRequest $request, BaseHttpResponse $response)
    {
        Stripe::setApiKey(gs()->payment_stripe_secret);
        $amount = $request->input('price');
        $stripeProduct = Product::create([
            'name' => $request->input('name'),
            'active' => true,
        ]);

        $stripProductPrice = Price::create([
            'currency' => 'usd',
            'unit_amount' => $amount * 100,
            'recurring' =>[ 'interval' =>  $request->input('subscription_plan_id') == 1 ? 'month' : 'year'],
            'product' => $stripeProduct->id
        ]);

        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $paypalProduct = $provider->createProduct([
            'name' => $request->input('name'),
            'description' => $request->input('name'),
            'type' => 'SERVICE',
            'category' =>   'SOFTWARE'
        ]);

        $paypalProductId = $paypalProduct['id'];

        $paypalPlan = $provider->createPlan([
            'product_id' => $paypalProductId,
            'name' => $request->input('name'),
            'description' => $request->input('name'),
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
                            'value' => $amount,
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
        //dd($paypalPlan);
        $subscription = Subscription::query()->create([
            'name' => $request->input('name'),
            'price' => $amount,
            'status' => $request->input('status'),
            'subscription_plan_id' => $request->input('subscription_plan_id'),
            'stripe_plan_id' => $stripProductPrice->id,
            'paypal_plan_id' => $paypalPlan['id']
        ]);

        $subscription->features()->attach($request->input('features'));

        event(new CreatedContentEvent(SUBSCRIPTIONS_MODULE_SCREEN_NAME, $request, $subscription));

        return $response
            ->setPreviousUrl(route('subscriptions.index'))
            ->setNextUrl(route('subscriptions.edit', $subscription->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Subscription $subscriptions, FormBuilder $formBuilder)
    {

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $subscriptions->name]));
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['stripe_plan_id' => $subscriptions->stripe_plan_id]));

        return $formBuilder->create(SubscritionsForm::class, ['model' => $subscriptions])->renderForm();
    }

    public function update(Subscription $subscriptions, SubscritionsRequest $request, BaseHttpResponse $response)
    {
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $subscriptions->fill($request->input());

        $price = Price::retrieve($$subscriptions->stripe_plan_id);
        $product = Product::retrieve($price->product);

        $planDetails = $provider->showPlanDetails($subscription->paypal_plan_id);
        $paypalProductId = $planDetails['product_id'];

        if($subscriptions->isDirty(['name'])) {
            $product->update(['name' => $request->input('name')]);

            $provider->updateProduct($paypalProductId, [
                [
                    'op' => 'replace',
                    'path' => '/name',
                    'value' => $request->input('name'),
                ],
                [
                    'op' => 'replace',
                    'path' => '/description',
                    'value' => $request->input('name'),
                ],
            ]);
        }

        if($subscriptions->isDirty(['price'])) {
            $price->delete();
            $amount = $request->input('price');

            $price = Price::create([
                'currency' => 'usd',
                'unit_amount' => $amount * 100,
                'recurring' =>[ 'interval' =>  $request->input('subscription_plan_id') == 1 ? 'month' : 'year'],
                'product' => $product->id
            ]);

            $provider->updatePlan($subscription->paypal_plan_id, [
                'op' => 'replace',
                'path' => '/status',
                'value' => 'INACTIVE',
            ]);

            $paypalPlan = $provider->createPlan([
                'product_id' => $paypalProductId,
                'name' => $request->input('name'),
                'description' => $request->input('name'),
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
                                'value' => $amount,
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

            $subscription->stripe_plan_id = $price->id;
        }

        $subscriptions->save();
        $subscriptions->features()->detach();
        $subscriptions->features()->attach($request->input('features'));

        event(new UpdatedContentEvent(SUBSCRIPTIONS_MODULE_SCREEN_NAME, $request, $subscriptions));

        return $response
            ->setPreviousUrl(route('subscriptions.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Subscription $subscriptions, Request $request, BaseHttpResponse $response)
    {
        try {
            $subscriptions->delete();

            $this->deleteStripeProduct($subscriptions);
            $this->deletePaypalProduct($subscription);

            event(new DeletedContentEvent(SUBSCRIPTIONS_MODULE_SCREEN_NAME, $request, $subscriptions));
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $subscription = Subscription::query()->findOrFail($id);
            $subscription->delete();

            $this->deleteStripeProduct($subscription);
            $this->deletePaypalProduct($subscription);

            event(new DeletedContentEvent(SUBSCRIPTIONS_MODULE_SCREEN_NAME, $request, $subscription));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    private function deleteStripeProduct($subscription)
    {
        $price = Price::retrieve($subscription->stripe_plan_id);
        $product = Product::retrieve($price->product);
        $product->delete();
    }

    private function deletePaypalProduct($subscription)
    {
        $provider = new PayPalClient([]);
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $planDetails = $provider->showPlanDetails($subscription->paypal_plan_id);
        $paypalProductId = $planDetails['product_id'];

        $provider->updatePlan($subscription->paypal_plan_id, [
            'op' => 'replace',
            'path' => '/status',
            'value' => 'INACTIVE'
        ]);

        $provider->updateProduct($paypalProductId, [
            'op' => 'replace',
            'path' => '/status',
            'value' => 'ARCHIVED'
        ]);
    }
}
