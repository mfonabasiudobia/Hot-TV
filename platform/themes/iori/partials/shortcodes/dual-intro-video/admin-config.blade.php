@php
    $fields = [
        'title' => [
            'title' => __('Title'),
        ],
        'subtitle' => [
            'title' => __('Subtitle')
        ],
        'description' => [
            'title' => __('Description')
        ],
        'image' => [
            'type'  => 'image',
            'title' => __('Image'),
        ],
        'youtube_video_url' => [
            'title' => __('Youtube video URL'),
        ],
        'button_label' => [
            'title' => __('Button label'),
        ],
    ];

    $max = 2;
@endphp

<section>
    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
</section>
