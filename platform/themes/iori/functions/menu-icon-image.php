<?php

use Botble\Base\Facades\MetaBox;
use Botble\Base\Forms\FormAbstract;
use Botble\Menu\Models\MenuNode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as IlluminateRequest;

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function (FormAbstract $form, Model $data): FormAbstract {
    if (get_class($data) == MenuNode::class) {
        $iconImage = $data->icon_image ?: $data->getMetaData('icon_image', true);
        $childStyle = $data->child_style ?: $data->getMetaData('child_style', true);

        if ($form->getFormHelper()->hasCustomField('themeIcon')) {
            $form
                ->modify('icon_font', 'themeIcon', [
                    'attr' => [
                        'placeholder' => null,
                    ],
                    'empty_value' => __('-- None --'),
                ]);
        }

        $form
            ->addAfter('icon_font', 'icon_image', 'mediaImage', [
                'label' => __('Icon image'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'data-update' => 'icon_image',
                ],
                'value' => $iconImage,
                'help_block' => [
                    'text' => __('It will replace Icon Font if it is present.'),
                ],
                'wrapper' => [
                    'style' => 'display: block;',
                ],
            ])
            ->addAfter('icon_image', 'child_style', 'customSelect', [
                'label' => __('Child style'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'data-update' => 'child_style',
                ],
                'choices' => [
                    '' => __('-- Default --'),
                    'two_col' => __('Two columns'),
                    'hr_per_2_child' => __('Add hr tag per 2 child'),
                ],
                'value' => $childStyle,
            ]);
    }

    return $form;
}, 124, 3);

add_action([BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT], function (string $type, IlluminateRequest $request, Model $object): void {
    if (get_class($object) == MenuNode::class) {
        if ($request->has('data.icon_image') || $request->has('data.child_style')) {
            if ($iconImage = $request->input('data.icon_image')) {
                MetaBox::saveMetaBoxData($object, 'icon_image', $iconImage);
            } else {
                MetaBox::deleteMetaData($object, 'icon_image');
            }

            if ($childStyle = $request->input('data.child_style')) {
                MetaBox::saveMetaBoxData($object, 'child_style', $childStyle);
            } else {
                MetaBox::deleteMetaData($object, 'child_style');
            }

            return;
        }

        $menuNodes = json_decode($request->input('menu_nodes'), true);

        foreach ($menuNodes as $node) {
            if ($node['menuItem']['id'] == $object->id) {
                if (isset($node['menuItem']['icon_image'])) {
                    if ($iconImage = $node['menuItem']['icon_image']) {
                        MetaBox::saveMetaBoxData($object, 'icon_image', $iconImage);
                    } else {
                        MetaBox::deleteMetaData($object, 'icon_image');
                    }
                }

                if (isset($node['menuItem']['child_style'])) {
                    if ($childStyle = $node['menuItem']['child_style']) {
                        MetaBox::saveMetaBoxData($object, 'child_style', $childStyle);
                    } else {
                        MetaBox::deleteMetaData($object, 'child_style');
                    }
                }

                break;
            }
        }
    }
}, 170, 3);

add_filter('menu_nodes_item_data', function (MenuNode $data): MenuNode {
    $data->icon_image = $data->getMetaData('icon_image', true);
    $data->child_style = $data->getMetaData('child_style', true);

    return $data;
}, 170);
