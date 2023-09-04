@php
    $tabs = [];
    $quantity = min((int) $shortcode->quantity, 20);
    if ($quantity) {
        for ($i = 1; $i <= $quantity; $i++) {
            $tabs[] = [
                'title' => $shortcode->{'title_' . $i},
                'data' => $shortcode->{'data_' . $i},
                'unit' => $shortcode->{'unit_' . $i},
            ];
        }
    }

    $style = in_array($shortcode->style, ['style-1', 'style-2']) ? $shortcode->style : 'style-1';
@endphp

{!! Theme::partial('shortcodes.site-statistics.styles.' . $style, compact('shortcode', 'tabs')) !!}
