<?php

namespace Botble\SubscriptionPlan\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Http\Requests\SubscriptionPlanRequest;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;

class SubscriptionPlanForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new SubscriptionPlan)
            ->setValidatorClass(SubscriptionPlanRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('trail', 'checkbox', [
                'label' => trans('plugins/subscription-plan::subscription-plan.trail'),
                'label_attr' => ['class' => 'control-label required'],
            ])
            ->add('trail_period', 'number', [
                'label' => trans('plugins/subscription-plan::subscription-plan.trail_period'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
