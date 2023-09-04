<?php

use ArchiElite\Career\Models\Career;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Arr;

if (is_plugin_active('career')) {
    add_shortcode('career-list', __('Career list'), __('Career list'), function (Shortcode $shortcode) {
        if (! $shortcode->career_ids) {
            return null;
        }

        $careerIds = explode(',', $shortcode->career_ids);

        if (! $careerIds) {
            return null;
        }

        $careers = Career::query()
            ->whereIn('id', $careerIds)
            ->wherePublished()
            ->get();

        return Theme::partial('shortcodes.career-list.index', compact('shortcode', 'careers'));
    });

    shortcode()->setAdminConfig('career-list', function (array $attributes) {
        $careers = Career::query()
            ->wherePublished()
            ->pluck('name', 'id')
            ->all();

        $careerIds = explode(',', Arr::get($attributes, 'career_ids'));

        return Theme::partial('shortcodes.career-list.admin-config', compact('attributes', 'careers', 'careerIds'));
    });
}
