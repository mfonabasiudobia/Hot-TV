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
        $subscription = Subscription::query()->create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'subscription_plan_id' => $request->input('subscription_plan_id'),
            'stripe_plan_id' => $request->input('stripe_plan_id')
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
        $subscriptions->fill($request->input());

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
            $subscription = Subscrition::query()->findOrFail($id);
            $subscription->delete();
            event(new DeletedContentEvent(SUBSCRIPTIONS_MODULE_SCREEN_NAME, $request, $subscription));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
