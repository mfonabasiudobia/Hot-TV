<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <textarea name="subtitle" class="form-control" >{{ Arr::get($attributes, 'subtitle') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Tag') }}</label>
        <input name="tag" value="{{ Arr::get($attributes, 'tag') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Youtube video URL') }}</label>
        <input name="youtube_video_url" value="{{ Arr::get($attributes, 'youtube_video_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Icon image') }}</label>
        {!! Form::mediaImage('icon_image', Arr::get($attributes, 'icon_image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
