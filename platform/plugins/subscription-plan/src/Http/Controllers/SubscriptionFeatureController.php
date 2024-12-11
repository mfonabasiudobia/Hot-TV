<?php

namespace Botble\SubscriptionPlan\Http\Controllers;

use Botble\SubscriptionPlan\Http\Requests\SubscriptionFeatureRequest;
use Botble\SubscriptionPlan\Models\SubscriptionFeature;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\SubscriptionPlan\Tables\SubscriptionFeatureTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SubscriptionPlan\Forms\SubscriptionFeatureForm;
use Botble\Base\Forms\FormBuilder;

class SubscriptionFeatureController extends BaseController
{
    public function index(SubscriptionFeatureTable $table)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscription-feature.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/subscription-plan::subscription-feature.create'));

        return $formBuilder->create(SubscriptionFeatureForm::class)->renderForm();
    }

    public function store(SubscriptionFeatureRequest $request, BaseHttpResponse $response)
    {
        $subscriptionFeature = SubscriptionFeature::query()->create($request->input());

        event(new CreatedContentEvent(SUBSCRIPTION_FEATURE_MODULE_SCREEN_NAME, $request, $subscriptionFeature));

        return $response
            ->setPreviousUrl(route('subscription-feature.index'))
            ->setNextUrl(route('subscription-feature.edit', $subscriptionFeature->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(SubscriptionFeature $subscriptionFeature, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $subscriptionFeature->name]));

        return $formBuilder->create(SubscriptionFeatureForm::class, ['model' => $subscriptionFeature])->renderForm();
    }

    public function update(SubscriptionFeature $subscriptionFeature, SubscriptionFeatureRequest $request, BaseHttpResponse $response)
    {
        $subscriptionFeature->fill($request->input());

        $subscriptionFeature->save();

        event(new UpdatedContentEvent(SUBSCRIPTION_FEATURE_MODULE_SCREEN_NAME, $request, $subscriptionFeature));

        return $response
            ->setPreviousUrl(route('subscription-feature.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(SubscriptionFeature $subscriptionFeature, Request $request, BaseHttpResponse $response)
    {
        try {
            $subscriptionFeature->delete();

            event(new DeletedContentEvent(SUBSCRIPTION_FEATURE_MODULE_SCREEN_NAME, $request, $subscriptionFeature));

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
            $subscriptionFeature = SubscriptionFeature::query()->findOrFail($id);
            $subscriptionFeature->delete();
            event(new DeletedContentEvent(SUBSCRIPTION_FEATURE_MODULE_SCREEN_NAME, $request, $subscriptionFeature));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
