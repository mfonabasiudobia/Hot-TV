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
        <label class="control-label">{{ __('Button url') }}</label>
        <input name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">
            <span>{{ __('Type') }}</span>
            <span class="fa fa-info-circle text-warning" title="{{ __('Not available if category is selected') }}"></span>
        </label>
        {!! Form::customSelect('type', [
                'default'  => __('Latest'),
                'featured' => __('Featured'),
                'recent'   => __('Recent'),
            ], Arr::get($attributes, 'type')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Number of displays') }}</label>
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
