<div class="form-group">
    <label>{{ trans('core/base::forms.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<div class="form-group">
    <label>{{ __('Number of display') }}</label>
    <input type="number" class="form-control" name="number_of_display" value="{{ $config['number_of_display'] }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Type') }}</label>
    {!! Form::customSelect('type', [
            'popular'   => __('Trending'),
            'on_sale'   => __('On sale'),
            'featured'  => __('Featured'),
        ], Arr::get($config, 'type')) !!}
</div>
