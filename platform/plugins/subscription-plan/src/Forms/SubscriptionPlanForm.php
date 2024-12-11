<?php

namespace Botble\SubscriptionPlan\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Http\Requests\SubscriptionPlanRequest;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Support\Str;

class SubscriptionPlanForm extends FormAbstract
{
    public function buildForm(): void
    {
        $selectedName = null;
        $selectedPeriod = null;


        $intervalMappings = get_interval_mappings();

        if($this->getModel()) {
            $name = $this->getModel()->name;
            $selectedPeriod = $this->getModel()->trail_period_stripe;

            foreach ($intervalMappings as $key => $mapping) {
                if($mapping == $name) {
                    $selectedName = $key;
                    break;
                }
            }
        }

        $this
            ->setupModel(new SubscriptionPlan)
            ->setValidatorClass(SubscriptionPlanRequest::class)
            ->withCustomFields()
            ->add('name', 'customSelect', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => $intervalMappings,
                'selected' => $selectedName,
            ])
            ->add('trail', 'onOff', [
                'label' => trans('plugins/subscription-plan::subscription-plan.trail'),
                'label_attr' => ['class' => 'control-label required'],
            ])
            ->add('trail_period', 'customSelect', [
                'label' => trans('plugins/subscription-plan::subscription-plan.trail_period'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => get_trail_mappings(),
                'selected' => $selectedPeriod,
                'validate' => 'required_if:trail,1',
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
