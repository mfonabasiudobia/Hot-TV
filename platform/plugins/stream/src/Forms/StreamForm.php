<?php

namespace Botble\Stream\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Stream\Http\Requests\StreamRequest;
use Botble\Stream\Models\Stream;

class StreamForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Stream)
            ->setValidatorClass(StreamRequest::class)
            ->withCustomFields()
            ->add('title', 'text', [
                'label' => trans('Title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                'placeholder' => trans('Title'),
                'data-counter' => 150,
            ],
            ])
            ->add('description', 'editor', [
                'label' => trans('Video Description'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                'rows' => 4,
                'placeholder' => trans('Video Description'),
                'data-counter' => 5000,
            ],
            ])
            ->add('schedule_date', 'date', [
                'label' => trans('Schedule a Date'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                'placeholder' => trans('Schedule a Date'),
            ]
            ])
            ->add('thumbnail', 'mediaImage', [
                'label' => trans('Thumbnail'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('rowOpen1', 'html', [
            'html' => '<div class="row">',
                ])
                ->add('start_time', 'time', [
                    'label' => 'Start Time',
                    'label_attr' => ['class' => 'control-label'],
                    'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                ])
                ->add('end_time', 'time', [
                    'label' => 'End Time',
                    'label_attr' => ['class' => 'control-label'],
                    'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                ])
                ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])
            ->add('stream_type', 'customSelect', [
                'label' => trans('Stream Type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => ['uploaded_video' => 'Uploaded Video', 'podcast' => 'Podcast'],
            ])
            ->add('recorded_video', 'mediaFile', [
                'label' => __('Upload Video'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                'accept' => "video/*",
            ]
            ]);
    }
}
