@php
    $style = in_array($shortcode->style, ['style-1', 'style-2', 'style-3']) ? $shortcode->style : 'style-1';
    $tabs = [];
        $quantity = min((int) $shortcode->quantity, 20);
        if ($quantity) {
            for ($i = 1; $i <= $quantity; $i++) {
                $tabs[] = [
                    'title' => $shortcode->{'title_' . $i},
                    'image' => $shortcode->{'image_' . $i},
                    'description' => $shortcode->{'description_' . $i},
                ];
            }
        }
@endphp

{!! Theme::partial('shortcodes.faqs.styles.' . $style, compact('shortcode', 'faqCategories', 'tabs')) !!}
