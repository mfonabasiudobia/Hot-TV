<section>
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
                'title' => __('Image'),
                'type' => 'image'
            ],

        ];
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes')) !!}
</section>
