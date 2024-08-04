<?php

namespace Botble\SubscriptionPlan\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Http\Requests\SubscritionsRequest;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Botble\SubscriptionPlan\Repositories\Interfaces\SubscriptionFeaturesInterface;
use Botble\SubscriptionPlan\Forms\Fields\FeatureMultiField;

class SubscritionsForm extends FormAbstract
{
    public function buildForm(): void
    {

        $selectedFeatures = [];
        if ($this->getModel()) {
            $selectedFeatures = $this->getModel()->features()->pluck('subscription_feature_id')->all();
        }

        if (empty($selectedFeatures)) {
            $selectedFeatures = app(SubscriptionFeaturesInterface::class)
                ->getModel()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->pluck('id')
                ->all();
        }

        if (! $this->formHelper->hasCustomField('featureMulti')) {
            $this->formHelper->addCustomField('featureMulti', FeatureMultiField::class);
        }


        $this
            ->setupModel(new Subscription)
            ->setValidatorClass(SubscritionsRequest::class)
            ->withCustomFields()
            ->add('subscription_plan_id', 'customSelect', [
                'label' => trans('plugins/subscription-plan::subscriptions.plans'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => ['' => trans('plugins/subscription-plan::subscriptions.select_plan')] + SubscriptionPlan::query()->pluck('name', 'id')->all(),
            ])
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('stripe_plan_id', 'text', [
                'label' => trans('plugins/subscription-plan::subscriptions.stripe_plan_id'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/subscription-plan::subscriptions.stripe_plan_id_placeholder'),
                ],
            ])
            ->add('paypal_plan_id', 'text', [
                'label' => trans('plugins/subscription-plan::subscriptions.paypal_plan_id'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/subscription-plan::subscriptions.paypal_plan_id_placeholder'),
                ],
            ])
            ->add('price', 'number', [
                'label' => trans('plugins/subscription-plan::subscriptions.price'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/subscription-plan::subscriptions.price'),
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('features[]', 'featureMulti', [
                'label' => 'Features',
                'label_attr' => ['class' => 'control-label required'],
                'choices' => get_features_with_children(),
                'value' => old('features', $selectedFeatures),
            ])
            ->setBreakFieldPoint('status');
    }
}
