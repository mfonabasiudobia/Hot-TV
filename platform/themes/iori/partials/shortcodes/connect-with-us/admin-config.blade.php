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

    $max = 3;
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea class="form-control" name="description">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button label') }}</label>
        <input name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button url') }}</label>
        <input name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
</section>
