<section>
    <div class="form-group mb-3">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea name="description" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
    </div>

    <div class="form-group mb-3">
        <label class="control-label">{{ __('Limit') }}</label>
        <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit') }}" class="form-control" placeholder="{{ __('Limit number of testimonials to show') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
                'style-3'  => __('Style :number', ['number' => 3]),
                'style-4'  => __('Style :number', ['number' => 4]),
                'style-5'  => __('Style :number', ['number' => 5]),
                'style-6'  => __('Style :number', ['number' => 6]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
