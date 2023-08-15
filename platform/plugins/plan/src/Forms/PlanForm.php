<?php

namespace Botble\Plan\Forms;

use Botble\Base\Enums\BaseDiscountTypeEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Plan\Http\Requests\PlanRequest;
use Botble\Plan\Models\Plan;

class PlanForm extends FormAbstract
{
    // protected $template = 'core/base::forms.form-tabs';

    public function buildForm(): void
    {

        $this
            ->setupModel(new Plan())
            ->setValidatorClass(PlanRequest::class)
            ->withCustomFields()
            // ->addCustomField('tags', TagField::class)
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 150,
                ],
            ])
            ->add('price', 'number', [
                'label' => trans('core/base::forms.price'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.price'),
                ],
                'default_value' => 0,
            ])
            ->add('discount_type', 'customSelect', [
                'label' => trans('core/base::tables.discount_type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => ['percent' => 'Percent', 'fixed' => 'Fixed'],
            ])
            ->add('discount_value', 'number', [
                'label' => trans('core/base::forms.discount_value'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.discount_value'),
                ],
                 'default_value' => 0,
                ])
            // ->add('description', 'textarea', [
            //     'label' => trans('core/base::forms.description'),
            //     'label_attr' => ['class' => 'control-label'],
            //     'attr' => [
            //         'rows' => 4,
            //         'placeholder' => trans('core/base::forms.description_placeholder'),
            //         'data-counter' => 400,
            //     ],
            // ])
            ->add('can_download', 'onOff', [
                'label' => trans('core/base::forms.can_download'),
                'label_attr' => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('can_stream', 'onOff', [
                'label' => trans('core/base::forms.can_stream'),
                'label_attr' => ['class' => 'control-label'],
                'default_value' => false,
            ]);
            // ->add('content', 'editor', [
            //     'label' => trans('core/base::forms.content'),
            //     'label_attr' => ['class' => 'control-label'],
            //     'attr' => [
            //         'rows' => 4,
            //         'placeholder' => trans('core/base::forms.description_placeholder'),
            //         'with-short-code' => true,
            //     ],
            // ])
            // ->add('status', 'customSelect', [
            //     'label' => trans('core/base::tables.status'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'choices' => BaseStatusEnum::labels(),
            // ])
            // ->add('categories[]', 'categoryMulti', [
            //     'label' => trans('plugins/Plan::posts.form.categories'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'choices' => get_categories_with_children(),
            //     'value' => old('categories', $selectedCategories),
            // ])
            // ->add('image', 'mediaImage', [
            //     'label' => trans('core/base::forms.image'),
            //     'label_attr' => ['class' => 'control-label'],
            // ])
            // ->add('tag', 'tags', [
            //     'label' => trans('plugins/Plan::posts.form.tags'),
            //     'label_attr' => ['class' => 'control-label'],
            //     'value' => $tags,
            //     'attr' => [
            //         'placeholder' => trans('plugins/Plan::base.write_some_tags'),
            //         'data-url' => route('tags.all'),
            //     ],
            // ])
           

        // $postFormats = get_post_formats(true);

        // if (count($postFormats) > 1) {
        //     $this->addAfter('status', 'format_type', 'customRadio', [
        //         'label' => trans('plugins/Plan::posts.form.format_type'),
        //         'label_attr' => ['class' => 'control-label'],
        //         'choices' => get_post_formats(true),
        //     ]);
        // }
    }
}
