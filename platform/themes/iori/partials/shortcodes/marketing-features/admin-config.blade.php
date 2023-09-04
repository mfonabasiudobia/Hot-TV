<section>
    <div class="form-group mb-3">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />

        <div class="form-group mb-3">
            <label class="control-label">{{ __('Style') }}</label>
            {!! Form::customSelect('style', [
                    'style-1'  => __('Style :number', ['number' => 1]),
                    'style-2'  => __('Style :number', ['number' => 2]),
                ], Arr::get($attributes, 'style')) !!}
        </div>
    </div>

    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'icon_image' => [
                'type'  => 'image',
                'title' => __('Icon image'),
            ],
            'description' => [
                'title' => __('Description'),
            ],
            'label' => [
                'title' => __('Button label')
            ],
            'url' => [
                'title' => __('Button url')
            ],
            'type' => [
               'type' => 'select',
               'title' => __('Type'),
               'options' => [
                   'personal' => __('Personal'),
                   'enterprise' => __('Enterprise'),
                ]
            ],
        ];
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
