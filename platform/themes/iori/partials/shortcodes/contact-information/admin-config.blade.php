<section>
    @php
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'email' => [
                'title' => __('Email'),
                'placeholder' => 'admin@example.com, admin1@example.com'
            ],
            'phone' => [
                'title' => __('Phone'),
                'placeholder' => '01234567890, 01234567891'
            ],
            'description' => [
                'title' => __('Description'),
            ],
            'image' => [
                'type'  => 'image',
                'title' => __('Image'),
            ],
        ];

        $max = 4;
    @endphp

    {!! Theme::partial('shortcodes.partials.tabs', compact('fields', 'attributes', 'max')) !!}
</section>
