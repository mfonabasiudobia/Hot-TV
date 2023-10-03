<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea class="form-control" name="description">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background Image') }}</label>
        {!! Form::mediaImage('background', Arr::get($attributes, 'background')) !!}
    </div>


    <div class="form-group">
        <label class="control-label">{{ __('Button primary label') }}</label>
        <input name="button_primary_label" value="{{ Arr::get($attributes, 'button_primary_label') }}"
            class="form-control" />
    </div>
    
    <div class="form-group">
        <label class="control-label">{{ __('Button primary url') }}</label>
        <input name="button_primary_url" value="{{ Arr::get($attributes, 'button_primary_url') }}" class="form-control" />
    </div>
    
    <div class="form-group">
        <label class="control-label">{{ __('Button secondary label') }}</label>
        <input name="button_secondary_label" value="{{ Arr::get($attributes, 'button_secondary_label') }}"
            class="form-control" />
    </div>
    
    <div class="form-group">
        <label class="control-label">{{ __('Button secondary url') }}</label>
        <input name="button_secondary_url" value="{{ Arr::get($attributes, 'button_secondary_url') }}"
            class="form-control" />
    </div>

    {{-- {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!} --}}

</section>