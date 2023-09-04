@php
    $fields = [
        'title' => [
            'title' => __('Title'),
        ],
        'data' => [
            'title' => __('Data'),
            'type' => 'number',
        ],
        'unit' => [
            'title' => __('Unit')
        ],
    ];

    $max = 3;

    $testimonialIds = explode(',', Arr::get($attributes, 'testimonial_ids'));
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
        <label class="control-label">{{ __('Description') }}</label>
        <textarea name="description" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    @foreach(range(1, 3) as $i)
        <div class="form-group">
            <label class="control-label">{{ __('Image :number', ['number' => $i]) }}</label>
            {!! Form::mediaImage('image_' . $i, Arr::get($attributes, 'image_' . $i)) !!}
        </div>
    @endforeach

    <div class="form-group">
        <label class="control-label">{{ __('Choose testimonials') }}</label>
        <select class="select-full" name="testimonial_ids" multiple>
            @foreach($testimonials as $testimonial)
                <option @selected(in_array($testimonial->id, $testimonialIds)) value="{{ $testimonial->id }}">{{ $testimonial->name }}</option>
            @endforeach
        </select>
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
