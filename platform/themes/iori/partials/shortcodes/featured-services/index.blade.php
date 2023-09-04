@php
    $tabs = [];
    $quantity = min((int) $shortcode->quantity, 20);
    if ($quantity) {
        for ($i = 1; $i <= $quantity; $i++) {
            $tabs[] = [
                'title' => $shortcode->{'title_' . $i},
                'description' => $shortcode->{'description_' . $i},
                'image' => $shortcode->{'image_' . $i},
                'action' => $shortcode->{'action_' . $i},
                'label' => $shortcode->{'label_' . $i},
            ];
        }
    }

    $style = in_array($shortcode->style, ['style-1', 'style-2', 'style-3', 'style-4']) ? $shortcode->style : 'style-1';
@endphp

{!! Theme::partial('shortcodes.featured-services.styles.' . $style, compact('shortcode', 'tabs')) !!}

