<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea class="form-control" name="description">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

</section>
