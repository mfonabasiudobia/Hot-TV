<?php

use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;

if (is_plugin_active('newsletter')) {
    add_shortcode('banner-with-newsletter-form', __('Banner with newsletter form'), __('Banner with newsletter form'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.banner-with-newsletter-form.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('banner-with-newsletter-form', function (array $attributes) {
        return Theme::partial('shortcodes.banner-with-newsletter-form.admin-config', compact('attributes'));
    });
}
