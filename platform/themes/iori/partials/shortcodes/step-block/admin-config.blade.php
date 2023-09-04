@php
    $fields = [
                'title' => [
                    'title' => __('Title'),
                ],

                'description' => [
                    'title' => __('Description'),
                ],
            ];
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

    <div class="form-group">
        <label class="control-label">{{ __('Button label') }}</label>
        <input name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button URL') }}</label>
        <input name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" />
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
