<?php

namespace Botble\SubscriptionPlan\Http\Controllers;

use Botble\SubscriptionPlan\Http\Requests\SubscriptionPlanRequest;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\SubscriptionPlan\Tables\SubscriptionPlanTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SubscriptionPlan\Forms\SubscriptionPlanForm;
use Botble\Base\Forms\FormBuilder;

class SubscriptionPlanController extends BaseController
{
    public function index(SubscriptionPlanTable $table)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscription-plan.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscription-plan.create'));

        return $formBuilder->create(SubscriptionPlanForm::class)->renderForm();
    }

    public function store(SubscriptionPlanRequest $request, BaseHttpResponse $response)
    {
        $subscriptionPlan = SubscriptionPlan::query()->create($request->input());

        event(new CreatedContentEvent(SUBSCRIPTION_PLAN_MODULE_SCREEN_NAME, $request, $subscriptionPlan));

        return $response
            ->setPreviousUrl(route('subscription-plan.index'))
            ->setNextUrl(route('subscription-plan.edit', $subscriptionPlan->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(SubscriptionPlan $subscriptionPlan, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $subscriptionPlan->name]));

        return $formBuilder->create(SubscriptionPlanForm::class, ['model' => $subscriptionPlan])->renderForm();
    }

    public function update(SubscriptionPlan $subscriptionPlan, SubscriptionPlanRequest $request, BaseHttpResponse $response)
    {

        $name = $request->input('name');
        $status = $request->input('status');
        $trail = $request->has('trail') ? 1 : 0;
        $trail_period = $request->input('trail_period');
        $subscriptionPlan->fill([
            'name' => $name,
            'status' => $status,
            'trail' => $trail,
            'trail_period' => $trail_period
        ]);

        $subscriptionPlan->save();

        event(new UpdatedContentEvent(SUBSCRIPTION_PLAN_MODULE_SCREEN_NAME, $request, $subscriptionPlan));

        return $response
            ->setPreviousUrl(route('subscription-plan.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(SubscriptionPlan $subscriptionPlan, Request $request, BaseHttpResponse $response)
    {
        try {
            $subscriptionPlan->delete();

            event(new DeletedContentEvent(SUBSCRIPTION_PLAN_MODULE_SCREEN_NAME, $request, $subscriptionPlan));

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
            $subscriptionPlan = SubscriptionPlan::query()->findOrFail($id);
            $subscriptionPlan->delete();
            event(new DeletedContentEvent(SUBSCRIPTION_PLAN_MODULE_SCREEN_NAME, $request, $subscriptionPlan));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
