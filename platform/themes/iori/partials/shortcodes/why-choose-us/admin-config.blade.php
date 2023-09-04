<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}"/>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea class="form-control" rows="3" placeholder="{{ __('Description') }}" name="description">{{ Arr::get($attributes, 'description') }}</textarea>
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
            'data' => [
                'title' => __('Data'),
            ],
           'color' => [
               'type' => 'select',
               'title' => __('Color'),
               'options' => [
                   '' => __('Default'),
                   'bg-brand-2' => __('Yellow'),
                   'bg-2' => __('Carrot'),
                   'bg-4' => __('Blue'),
                ]
            ],
        ];
        $max = 4;
        $current = 4;
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max', 'current')) !!}
</section>
