<section>
    @php
        $fields = [
            'heading' => [
                'title' => __('Heading'),
            ],
            'description' => [
                'title' => __('Description'),
            ],
            'icon' => [
                'type'  => 'image',
                'title' => __('Image'),
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
        <label class="control-label">{{ __('Button Label') }}</label>
        <input type="text" name="title_button" value="{{ Arr::get($attributes, 'title_button') }}" class="form-control" placeholder="{{ __('Title Button') }}">
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
</section>
