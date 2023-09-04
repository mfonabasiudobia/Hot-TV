<?php

use Botble\Base\Facades\Html;
use Botble\BusinessService\Models\Package;
use Botble\BusinessService\Models\Service;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;

if (is_plugin_active('business-services')) {
    add_shortcode('services', __('Services'), __('Services'), function (Shortcode $shortcode) {
        $serviceIds = explode(',', $shortcode->service_ids);

        if (! $serviceIds) {
            return null;
        }

        $services = Service::query()
            ->whereIn('id', $serviceIds)
            ->wherePublished()
            ->get();

        $style = in_array($shortcode->style, ['style-1', 'style-2', 'style-3', 'style-4']) ? $shortcode->style : 'style-1';

        return Theme::partial(
            "shortcodes.services.styles.$style",
            compact('shortcode', 'services')
        );
    });

    shortcode()->setAdminConfig('services', function (array $attributes) {
        $services = Service::query()
            ->wherePublished()
            ->pluck('name', 'id')
            ->all();

        $serviceIds = explode(',', Arr::get($attributes, 'service_ids'));

        return Theme::partial('shortcodes.services.admin-config', compact('attributes', 'services', 'serviceIds'));
    });

    add_shortcode('pricing-plan', __('Pricing Plan'), __('Pricing Plan'), function (Shortcode $shortcode) {
        $packageIds = explode(',', $shortcode->package_ids);

        if (! $packageIds) {
            return null;
        }

        $packages = Package::query()
            ->wherePublished()
            ->whereIn('id', $packageIds)
            ->get();

        $styleBg = ['bg-fourth-bg', 'bg-first-bg', 'bg-second-bg', 'bg-fifth-bg'];
        $style = in_array($shortcode->style, ['style-1', 'style-2']) ? $shortcode->style : 'style-1';

        return Theme::partial(
            "shortcodes.pricing-plan.styles.$style",
            compact('shortcode', 'packages', 'styleBg')
        );
    });

    shortcode()->setAdminConfig('pricing-plan', function (array $attributes) {
        $packages = Package::query()
            ->wherePublished()
            ->pluck('name', 'id')
            ->all();

        return Html::style('vendor/core/core/base/libraries/tagify/tagify.css') .
            Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
            Html::script('vendor/core/core/base/js/tags.js') .
            Theme::partial('shortcodes.pricing-plan.admin-config', compact('attributes', 'packages'));
    });
}
