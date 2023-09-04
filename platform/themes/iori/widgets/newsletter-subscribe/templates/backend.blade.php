<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ $config['title'] }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ $config['subtitle'] }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

<div class="form-group">
    <label for="platform_google_play_logo">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', Arr::get($config, 'image')) !!}
</div>

<div class="form-group">
    <label for="icon_primary">{{ __('Icon primary') }}</label>
    {!! Form::mediaImage('icon_primary', Arr::get($config, 'icon_primary')) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Style') }}</label>
    {!! Form::customSelect('style', [
            1  => __('Style :number', ['number' => 1]),
            2  => __('Style :number', ['number' => 2]),
        ], Arr::get($config, 'style')) !!}
</div>
