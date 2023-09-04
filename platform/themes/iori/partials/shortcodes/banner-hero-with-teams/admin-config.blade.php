@php
    $teamIds = explode(',', Arr::get($attributes, 'team_ids'));
@endphp

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
        <lable class="control-label">{{ __('Description') }}</lable>
        <textarea class="form-control" name="description" rows="3">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button primary label') }}</label>
        <input name="button_primary_label" value="{{ Arr::get($attributes, 'button_primary_label') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button primary URL') }}</label>
        <input name="button_primary_url" value="{{ Arr::get($attributes, 'button_primary_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button secondary label') }}</label>
        <input name="button_secondary_label" value="{{ Arr::get($attributes, 'button_secondary_label') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button secondary URL') }}</label>
        <input name="button_secondary_url" value="{{ Arr::get($attributes, 'button_secondary_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('GooglePlay logo') }}</label>
        {!! Form::mediaImage('google_play_logo', Arr::get($attributes, 'google_play_logo')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('GooglePlay url') }}</label>
        <input name="google_play_url" value="{{ Arr::get($attributes, 'google_play_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('AppleStore logo') }}</label>
        {!! Form::mediaImage('apple_store_logo', Arr::get($attributes, 'apple_store_logo')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('AppleStore url') }}</label>
        <input name="apple_store_url" value="{{ Arr::get($attributes, 'apple_store_url') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Choose teams') }}</label>
        <select class="select-full" name="team_ids" multiple>
            @foreach($teams as $team)
                <option @selected(in_array($team->id, $teamIds)) value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
                'style-1'  => __('Style :number', ['number' => 1]),
                'style-2'  => __('Style :number', ['number' => 2]),
            ], Arr::get($attributes, 'style')) !!}
    </div>
</section>
