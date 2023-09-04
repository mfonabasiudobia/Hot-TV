@php
    $fields = [
           'title' => [
               'title' => __('Title'),
           ],
           'description' => [
               'title' => __('Description')
           ],
           'image' => [
               'title' => __('Image'),
               'type' => 'image'
           ],
           'topics' => [
               'title' => __('Topics')
           ],
           'comments' => [
               'title' => __('Comments')
           ],
           'account' => [
                'title' => __('Account'),
                'type' => 'select',
                'options' => $teams
            ]
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
