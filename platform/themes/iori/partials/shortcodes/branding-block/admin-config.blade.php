@php
    $fields = [
        'title' => [
            'title' => __('Title'),
        ],
    ];

    $max = 6;
@endphp

<section class="section mt-50">
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea class="form-control" name="description" rows="3">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image 1') }}</label>
        {!! Form::mediaImage('image_1', Arr::get($attributes, 'image_!')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image 2') }}</label>
        {!! Form::mediaImage('image_2', Arr::get($attributes, 'image_2')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Logo') }}</label>
        {!! Form::mediaImage('logo', Arr::get($attributes, 'logo')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button primary label') }}</label>
        <input name="button_primary_label" value="{{ Arr::get($attributes, 'button_primary_label') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button primary url') }}</label>
        <input name="button_primary_url" value="{{ Arr::get($attributes, 'button_primary_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button secondary label') }}</label>
        <input name="button_secondary_label" value="{{ Arr::get($attributes, 'button_secondary_label') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button secondary url') }}</label>
        <input name="button_secondary_url" value="{{ Arr::get($attributes, 'button_secondary_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Counter title') }}</label>
        <input name="counter_title" value="{{ Arr::get($attributes, 'counter_title') }}" class="form-control" />

    <div class="form-group">
        <label class="control-label">{{ __('Counter data') }}</label>
        <input name="counter_data" value="{{ Arr::get($attributes, 'counter_data') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Counter unit') }}</label>
        <input name="counter_unit" value="{{ Arr::get($attributes, 'counter_unit') }}" class="form-control" />
    </div>

     <div class="form-group">
        <label class="control-label">{{ __('Counter title 1') }}</label>
        <input name="counter_title_1" value="{{ Arr::get($attributes, 'counter_title_1') }}" class="form-control" />

    <div class="form-group">
        <label class="control-label">{{ __('Counter data 1') }}</label>
        <input name="counter_data_1" value="{{ Arr::get($attributes, 'counter_data_1') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Counter unit 1') }}</label>
        <input name="counter_unit_1" value="{{ Arr::get($attributes, 'counter_unit_1') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
                'style-3'  => __('Style :number', ['number' => 3]),
                'style-4'  => __('Style :number', ['number' => 4]),
                'style-5'  => __('Style :number', ['number' => 5]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
