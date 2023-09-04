<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Category') }}</label>
        {!! Form::customSelect('category_id', $categories->pluck('name', 'id'), Arr::get($attributes, 'style')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Number of post') }}</label>
        <input name="limit" value="{{ Arr::get($attributes, 'limit') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
