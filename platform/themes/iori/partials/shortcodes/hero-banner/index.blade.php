@php
    $tabs = [];
        $quantity = min((int) $shortcode->quantity, 20);
        if ($quantity) {
            for ($i = 1; $i <= $quantity; $i++) {
                $tabs[] = [
                    'title' => $shortcode->{'title_' . $i},
                    'url' => $shortcode->{'url_' . $i},
                    'image' => $shortcode->{'image_' . $i},
                    'description' => $shortcode->{'description_' . $i},
                ];
            }
        }

    $style = in_array($shortcode->style, ['style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11']) ? $shortcode->style : 'style-1';
@endphp

{!! Theme::partial('shortcodes.hero-banner.styles.' . $style, compact('shortcode', 'tabs', 'customers')) !!}
