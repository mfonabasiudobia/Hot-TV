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
        <label class="control-label">{{ __('Icon image') }}</label>
        {!! Form::mediaImage('icon_image', Arr::get($attributes, 'icon_image')) !!}
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

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
            'style-1'  => __('Style :number', ['number' => 1]),
            'style-2'  => __('Style :number', ['number' => 2]),
        ], Arr::get($attributes, 'style')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Packages') }}</label>
        <input type="text" name="package_ids" data-list="{{ json_encode($packages) }}" value="{{ Arr::get($attributes, 'package_ids') }}" class="form-control list-tagify" placeholder="{{ __('Choose packages for this pricing') }}">
    </div>
</section>
