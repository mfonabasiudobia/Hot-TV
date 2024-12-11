<?php

namespace Botble\SubscriptionPlan\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Http\Requests\SubscriptionFeatureRequest;
use Botble\SubscriptionPlan\Models\SubscriptionFeature;

class SubscriptionFeatureForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new SubscriptionFeature)
            ->setValidatorClass(SubscriptionFeatureRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
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
            ->setBreakFieldPoint('status');
    }
}
