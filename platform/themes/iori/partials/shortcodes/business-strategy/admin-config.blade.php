@php
    $fields = [
           'title' => [
               'title' => __('Title'),
           ],
       ];

   $max = 6;
@endphp
<section>
    <div class="form-group mb-3">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group mb-3">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Icon image') }}</label>
        {!! Form::mediaImage('icon_image', Arr::get($attributes, 'icon_image')) !!}
    </div>

    <div class="form-group mb-3">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea name="description" rows="3" class="form-control" >{{ Arr::get($attributes, 'subtitle') }}</textarea>
    </div>

    <div class="form-group mb-3">
        {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
    </div>

    <div class="form-group mb-3">
        @foreach(range(1, 3) as $i)
            <div class="form-group">
                <label class="control-label">{{ __('Counter number :number', ['number' => $i]) }}</label>
                <input name="{{ "counter_number_$i" }}" value="{{ Arr::get($attributes, "counter_number_$i") }}" class="form-control" />
            </div>

            <div class="form-group">
                <label class="control-label">{{ __('Counter label :number', ['number' => $i]) }}</label>
                <input name="{{ "counter_label_$i" }}" value="{{ Arr::get($attributes, "counter_label_$i") }}" class="form-control" />
            </div>
        @endforeach
    </div>
</section>
