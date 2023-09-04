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
    ];

@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Google play logo') }}</label>
        {!! Form::mediaImage('google_play_logo', Arr::get($attributes, 'google_play_logo')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Google play URL') }}</label>
        <input name="google_play_url" value="{{ Arr::get($attributes, 'google_play_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Apple store logo') }}</label>
        {!! Form::mediaImage('apple_store_logo', Arr::get($attributes, 'apple_store_logo')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Apple store URL') }}</label>
        <input name="apple_store_url" value="{{ Arr::get($attributes, 'apple_store_url') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
