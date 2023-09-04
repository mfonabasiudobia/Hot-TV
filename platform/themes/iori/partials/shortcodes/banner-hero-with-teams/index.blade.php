@php
    $style = in_array($shortcode->style, ['style-1', 'style-2']) ? $shortcode->style : 'style-1';
@endphp

{!! Theme::partial('shortcodes.banner-hero-with-teams.styles.' . $style, compact('shortcode', 'teams')) !!}
