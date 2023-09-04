<?php

use Botble\Ecommerce\Models\ProductCategory;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;

if (is_plugin_active('ecommerce')) {
    add_shortcode('featured-categories', __('Featured Categories'), __('Featured Categories'), function (Shortcode $shortcode) {
        if (! $shortcode->category_ids) {
            return null;
        }

        $categoryIds = explode(',', $shortcode->category_ids);

        if (! $categoryIds) {
            return null;
        }

        $categories = ProductCategory::query()
            ->whereIn('id', $categoryIds)
            ->wherePublished()
            ->where('is_featured', 1)
            ->orderByDesc('created_at')
            ->orderBy('order')
            ->get();

        return Theme::partial('shortcodes.featured-categories.index', compact('shortcode', 'categories'));
    });

    shortcode()->setAdminConfig('featured-categories', function (array $attributes) {
        $categories = ProductCategory::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->orderBy('order')
            ->get();

        return Theme::partial('shortcodes.featured-categories.admin-config', compact('attributes', 'categories'));
    });
}
