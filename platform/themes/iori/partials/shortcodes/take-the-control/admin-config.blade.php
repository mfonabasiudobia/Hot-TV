@php
    $fields = [
        'title' => [
            'title' => __('Title'),
        ],
        'image' => [
            'type'  => 'image',
            'title' => __('Image'),
        ],
        'description' => [
            'title' => __('Description'),
        ],
    ];

    $max = 2;
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    <div class="form-control">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Title counter') }}</label>
        <input name="title_counter" value="{{ Arr::get($attributes, 'title_counter') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Data counter') }}</label>
        <input name="data_counter" value="{{ Arr::get($attributes, 'data_count') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Unit counter') }}</label>
        <input name="unit_counter" value="{{ Arr::get($attributes, 'unit_counter') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
</section>
