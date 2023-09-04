<?php

namespace Botble\BusinessService\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\BusinessService\Http\Requests\ServiceCategoryRequest;
use Botble\BusinessService\Models\ServiceCategory;

class ServiceCategoryForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new ServiceCategory())
            ->setValidatorClass(ServiceCategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'form-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('parent_id', 'customSelect', [
                'label' => trans('core/base::forms.parent'),
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'class' => 'select-search-full',
                ],
                'choices' => ['' => trans('plugins/business-services::business-services.form.none')] + ServiceCategory::query()
                        ->where('parent_id', null)
                        ->pluck('name', 'id')
                        ->all(),
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'select-search-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label' => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
