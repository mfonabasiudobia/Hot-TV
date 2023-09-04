@php
    $fields = [
        'title' => [
            'title' => __('Title'),
        ],
        'free' => [
            'title' => __('Free'),
        ],
        'standard' => [
            'title' => __('Standard')
        ],
        'business' => [
            'title' => __('Business')
        ],
        'enterprise' => [
            'title' => __('Enterprise')
        ],
    ];
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
