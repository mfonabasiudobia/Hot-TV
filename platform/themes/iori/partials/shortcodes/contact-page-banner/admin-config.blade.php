<section>
    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'image' => [
                'type'  => 'image',
                'title' => __('Image'),
            ],
            'link_to' => [
                'title' => __('Link to'),
            ],
        ];

        $max = 3;
    @endphp

    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <input type="text" name="description" value="{{ Arr::get($attributes, 'description') }}" class="form-control" placeholder="{{ __('Description') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button label') }}</label>
        <input type="text" name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" placeholder="{{ __('Button label') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button url') }}</label>
        <input type="text" name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" placeholder="{{ __('Button url') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Banner') }}</label>
        {!! Form::mediaImage('banner', Arr::get($attributes, 'banner')) !!}
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
</section>
