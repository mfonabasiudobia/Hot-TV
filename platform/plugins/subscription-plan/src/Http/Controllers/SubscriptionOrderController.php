<?php

namespace Botble\SubscriptionPlan\Http\Controllers;

use Botble\SubscriptionPlan\Http\Requests\SubscriptionOrderRequest;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\SubscriptionPlan\Tables\SubscriptionOrderTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SubscriptionPlan\Forms\SubscriptionOrderForm;
use Botble\Base\Forms\FormBuilder;

class SubscriptionOrderController extends BaseController
{
    public function index(SubscriptionOrderTable $table)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscription-order.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscription-order.create'));

        return $formBuilder->create(SubscriptionOrderForm::class)->renderForm();
    }

    public function store(SubscriptionOrderRequest $request, BaseHttpResponse $response)
    {
        $subscriptionOrder = SubscriptionOrder::query()->create($request->input());

        event(new CreatedContentEvent(SUBSCRIPTION_ORDER_MODULE_SCREEN_NAME, $request, $subscriptionOrder));

        return $response
            ->setPreviousUrl(route('subscription-order.index'))
            ->setNextUrl(route('subscription-order.edit', $subscriptionOrder->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(SubscriptionOrder $subscriptionOrder, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $subscriptionOrder->name]));

        return $formBuilder->create(SubscriptionOrderForm::class, ['model' => $subscriptionOrder])->renderForm();
    }

    public function update(SubscriptionOrder $subscriptionOrder, SubscriptionOrderRequest $request, BaseHttpResponse $response)
    {
        $subscriptionOrder->fill($request->input());

        $subscriptionOrder->save();

        event(new UpdatedContentEvent(SUBSCRIPTION_ORDER_MODULE_SCREEN_NAME, $request, $subscriptionOrder));

        return $response
            ->setPreviousUrl(route('subscription-order.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(SubscriptionOrder $subscriptionOrder, Request $request, BaseHttpResponse $response)
    {
        try {
            $subscriptionOrder->delete();

            event(new DeletedContentEvent(SUBSCRIPTION_ORDER_MODULE_SCREEN_NAME, $request, $subscriptionOrder));

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
            $subscriptionOrder = SubscriptionOrder::query()->findOrFail($id);
            $subscriptionOrder->delete();
            event(new DeletedContentEvent(SUBSCRIPTION_ORDER_MODULE_SCREEN_NAME, $request, $subscriptionOrder));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
