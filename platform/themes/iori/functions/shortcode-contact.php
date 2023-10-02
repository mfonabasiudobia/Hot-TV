<?php

use Botble\Theme\Facades\Theme;

if (is_plugin_active('contact')) {
    // add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
    //     return Theme::getThemeNamespace('partials.shortcodes.contact-form.index');
    // }, 120);

    // shortcode()->setAdminConfig('contact-form', function (array $attributes) {
    //     return Theme::partial('shortcodes.contact-form.admin-config', compact('attributes'));
    // });
}
