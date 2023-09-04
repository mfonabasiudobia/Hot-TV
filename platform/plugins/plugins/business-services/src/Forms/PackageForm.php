<?php

namespace Botble\BusinessService\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\BusinessService\Enums\PackageDuration;
use Botble\BusinessService\Http\Requests\PackageRequest;
use Botble\BusinessService\Models\Package;

class PackageForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Package())
            ->setValidatorClass(PackageRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'form-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => trans('plugins/business-services::business-services.form.description_placeholder'),
                    'data-counter' => 400,
                    'rows' => 2,
                ],
            ])
            ->add('content', 'editor', [
                'label' => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'form-label required'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('duration', 'customSelect', [
                'label' => trans('plugins/business-services::business-services.duration'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'select-search-full',
                ],
                'choices' => PackageDuration::labels(),
                'selected' => PackageDuration::MONTHLY,
            ])
            ->add('price', 'text', [
                'label' => trans('plugins/business-services::business-services.price'),
                'label_attr' => ['class' => 'form-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/business-services::business-services.form.price_placeholder'),
                ],
            ])
            ->add('features', 'textarea', [
                'label' => trans('plugins/business-services::business-services.form.features'),
                'label_attr' => ['class' => 'form-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/business-services::business-services.form.features_placeholder'),
                ],
                'help_block' => [
                    'text' => trans('plugins/logistics::logistics.form.features_help_block'),
                ],
            ])
            ->add('is_popular', 'onOff', [
                'label' => trans('plugins/business-services::business-services.is_popular'),
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'select-search-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
