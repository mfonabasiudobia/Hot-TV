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

    $max = 2;

    $categoryIds = explode(',', Arr::get($attributes, 'category_ids'));
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
        <label class="control-label">{{ __('Choose categories') }}</label>
        <select class="select-full" name="category_ids" multiple>
            @foreach($categories as $category)
                <option @selected(in_array($category->id, $categoryIds)) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
                'style-3'  => __('Style :number', ['number' => 3]),
                'style-4'  => __('Style :number', ['number' => 4]),
                'style-5'  => __('Style :number', ['number' => 5]),
                'style-6'  => __('Style :number', ['number' => 6]),
                'style-7'  => __('Style :number', ['number' => 7]),
                'style-8'  => __('Style :number', ['number' => 8]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
