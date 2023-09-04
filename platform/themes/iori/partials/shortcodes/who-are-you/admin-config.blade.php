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
        <label class="control-label">{{ __('Description') }}</label>
        <input name="description" value="{{ Arr::get($attributes, 'description') }}" class="form-control" />
    </div>

    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'image' => [
                'title' => __('Image'),
                'type' => 'image'
            ],
            'data' => [
                'title' => __('Data'),
                'type' => 'number',
            ],
            'unit' => [
                'title' => __('Unit')
            ],
        ];
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
