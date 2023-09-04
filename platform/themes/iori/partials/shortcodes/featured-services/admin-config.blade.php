<section>
    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'description' => [
                'title' => __('Description')
            ],
            'image' => [
                'title' => __('Image'),
                'type' => 'image'
            ],
            'action' => [
                'title' => __('Action')
            ],
            'label' => [
                'title' => __('Label')
            ],
        ];
    @endphp

    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
                'style-3'  => __('Style :number', ['number' => 3]),
                'style-4'  => __('Style :number', ['number' => 4]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
