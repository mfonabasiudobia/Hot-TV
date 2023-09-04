<div class="form-group">
    <label for="logo">{{ __('Logo') }}</label>
    {!! Form::mediaImage('logo', Arr::get($config, 'logo')) !!}
</div>

<div class="form-group">
    <label for="widget-name">{{ __('URL') }}</label>
    <input type="text" id="url" name="url" class="form-control" value="{{ Arr::get($config, 'url') }}">
</div>

<div class="form-group">
    <label for="address">{{ __('Address') }}</label>
    <textarea id="address" class="form-control" name="address">{{ Arr::get($config, 'address') }}</textarea>
</div>

<div class="form-group">
    <label>{{ __('Working hours start') }}</label>
    <input type="time" step="3600" class="form-control" name="working_hours_start" value="{{ $config['working_hours_start'] }}">
</div>

<div class="form-group">
    <label>{{ __('Working hours end') }}</label>
    <input type="time" step="3600" class="form-control" name="working_hours_end" value="{{ $config['working_hours_end'] }}">
</div>
