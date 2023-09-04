@php
    $fields = [
        'key' => [
            'title' => __('Key'),
        ],
        'title' => [
            'title' => __('Title'),
        ],
        'subtitle' => [
            'title' => __('Subtitle'),
        ],
        'description' => [
            'title' => __('Description'),
        ],
        'image' => [
            'title' => __('Image'),
            'type' => 'image'
        ],
        'checklists' => [
            'title' => __('Checklists'),
            'placeholder' => __('Task1, Task2,...')
        ],
    ];
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

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
