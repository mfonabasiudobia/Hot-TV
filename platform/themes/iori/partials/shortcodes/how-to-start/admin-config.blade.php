<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image icon primary') }}</label>
        {!! Form::mediaImage('image_icon_primary', Arr::get($attributes, 'image_icon_primary')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image icon secondary') }}</label>
        {!! Form::mediaImage('image_icon_secondary', Arr::get($attributes, 'image_icon_secondary')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
            ], Arr::get($attributes, 'style')) !!}
    </div>

    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'description' => [
                'title' => __('Description'),
            ],
        ];

        $max = 4;
        $current = 4;
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max', 'current')) !!}
</section>
