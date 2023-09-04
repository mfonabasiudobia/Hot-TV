@php
    $tabs = [];
    $quantity = min((int) $shortcode->quantity, 20);
    if ($quantity) {
        for ($i = 1; $i <= $quantity; $i++) {
            $tabs[] = [
                'title' => $shortcode->{'title_' . $i},
                'description' => $shortcode->{'description_' . $i},
                'icon_image' => $shortcode->{'icon_image_' . $i},
                'label' => $shortcode->{'label_' . $i},
                'url' => $shortcode->{'url_' . $i},
                'type' => $shortcode->{'type_' . $i},
            ];
        }
    }

    $style = in_array($shortcode->style, ['style-1', 'style-2']) ? $shortcode->style : 'style-1';
@endphp

{!! Theme::partial('shortcodes.marketing-features.styles.' . $style, compact('shortcode', 'tabs')) !!}
