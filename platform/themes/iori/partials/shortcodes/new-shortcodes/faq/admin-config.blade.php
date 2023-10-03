<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Short Title') }}</label>
        <input name="short_title" value="{{ Arr::get($attributes, 'short_title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <input name="description" value="{{ Arr::get($attributes, 'description') }}" class="form-control" />
    </div>

</section>
