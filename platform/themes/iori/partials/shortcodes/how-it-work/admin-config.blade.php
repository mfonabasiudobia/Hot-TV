<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    <div class="form-group mb-3">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea name="description" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
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

    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'description' => [
                'title' => __('Description'),
            ],
            'icon_image' => [
                'type'  => 'image',
                'title' => __('Icon image'),
            ],
            'label' => [
                'title' => __('Label'),
            ],
            'url' => [
                'title' => __('URL'),
            ],
            'display' => [
               'type' => 'select',
               'title' => __('Display'),
               'options' => [
                   'show_full' => __('Show full'),
                   'show_title' => __('Show title'),
                ],
            ],
        ];
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
