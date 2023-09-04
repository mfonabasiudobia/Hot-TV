<?php

use Botble\Shortcode\Compilers\Shortcode;
use Botble\Testimonial\Models\Testimonial;
use Botble\Theme\Facades\Theme;

if (is_plugin_active('testimonial')) {
    add_shortcode('testimonials', __('Testimonials'), __('Testimonials'), function (Shortcode $shortcode) {
        $testimonials = Testimonial::query()
            ->wherePublished()
            ->limit(4)
            ->get();

        return Theme::partial('shortcodes.testimonials.index', compact('shortcode', 'testimonials'));
    });

    shortcode()->setAdminConfig('testimonials', function (array $attributes) {
        return Theme::partial('shortcodes.testimonials.admin-config', compact('attributes'));
    });

    add_shortcode('why-using-your-app', __('Why using your app'), __('Why using your app'), function (Shortcode $shortcode) {
        if (! $testimonialId = $shortcode->testimonial_id) {
            return null;
        }

        $testimonial = Testimonial::query()->find($testimonialId);

        return Theme::partial('shortcodes.why-using-your-app.index', compact('shortcode', 'testimonial'));
    });

    shortcode()->setAdminConfig('why-using-your-app', function (array $attributes) {
        $testimonials = Testimonial::query()
            ->wherePublished()
            ->get();

        return Theme::partial('shortcodes.why-using-your-app.admin-config', compact('attributes', 'testimonials'));
    });

    add_shortcode('business-statistics', __('Business statistics'), __('Business statistics'), function (Shortcode $shortcode) {
        if (! $shortcode->testimonial_ids) {
            return null;
        }

        $testimonialIds = explode(',', $shortcode->testimonial_ids);

        if (! $testimonialIds) {
            return null;
        }

        $testimonials = Testimonial::query()
            ->wherePublished()
            ->whereIn('id', $testimonialIds)
            ->get();

        return Theme::partial('shortcodes.business-statistics.index', compact('shortcode', 'testimonials'));
    });

    shortcode()->setAdminConfig('business-statistics', function (array $attributes) {
        $testimonials = Testimonial::query()
            ->wherePublished()
            ->get();

        return Theme::partial('shortcodes.business-statistics.admin-config', compact('attributes', 'testimonials'));
    });
}
