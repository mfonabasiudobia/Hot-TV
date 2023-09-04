<?php

use Botble\Shortcode\Compilers\Shortcode;
use Botble\Team\Models\Team;
use Botble\Theme\Facades\Theme;

if (is_plugin_active('team')) {
    add_shortcode('teams', __('Teams'), __('Teams'), function ($shortcode) {
        if (! $shortcode->team_ids) {
            return null;
        }

        $teamIds = explode(',', $shortcode->team_ids);

        if (! $teamIds) {
            return null;
        }

        $teams = Team::query()
            ->whereIn('id', $teamIds)
            ->wherePublished()
            ->orderByDesc('created_at')
            ->limit((int)$shortcode->limit ?: 4)
            ->get();

        return Theme::partial('shortcodes.teams.index', compact('shortcode', 'teams'));
    });

    shortcode()->setAdminConfig('teams', function (array $attributes) {
        $teams = Team::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->get();

        return Theme::partial('shortcodes.teams.admin-config', compact('attributes', 'teams'));
    });

    add_shortcode('board-members', __('Board members'), __('Board members'), function (Shortcode $shortcode) {
        if (! $shortcode->team_ids) {
            return null;
        }

        $teamIds = explode(',', $shortcode->team_ids);

        if (! $teamIds) {
            return null;
        }

        $teams = Team::query()
            ->whereIn('id', $teamIds)
            ->wherePublished()
            ->orderByDesc('created_at')
            ->limit((int)$shortcode->limit ?: 8)
            ->get();

        return Theme::partial('shortcodes.board-members.index', compact('shortcode', 'teams'));
    });

    shortcode()->setAdminConfig('board-members', function (array $attributes) {
        $teams = Team::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->get();

        return Theme::partial('shortcodes.board-members.admin-config', compact('attributes', 'teams'));
    });

    add_shortcode('banner-hero-with-teams', __('Banner hero with teams'), __('Banner hero with teams'), function (Shortcode $shortcode) {
        if (! $shortcode->team_ids) {
            return null;
        }

        $teamIds = explode(',', $shortcode->team_ids);

        if (! $teamIds) {
            return null;
        }

        $teams = Team::query()
            ->whereIn('id', $teamIds)
            ->wherePublished()
            ->orderByDesc('created_at')
            ->limit((int)$shortcode->limit ?: 5)
            ->get();

        return Theme::partial('shortcodes.banner-hero-with-teams.index', compact('shortcode', 'teams'));
    });

    shortcode()->setAdminConfig('banner-hero-with-teams', function (array $attributes) {
        $teams = Team::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->get();

        return Theme::partial('shortcodes.banner-hero-with-teams.admin-config', compact('attributes', 'teams'));
    });

    add_shortcode('from-community-forums', __('From community forums'), __('From community forums'), function (Shortcode $shortcode) {
        $tabs = [];
        $quantity = min((int) $shortcode->quantity, 20);
        if ($quantity) {
            for ($i = 1; $i <= $quantity; $i++) {
                $tabs[] = [
                    'title' => $shortcode->{'title_' . $i},
                    'description' => $shortcode->{'description_' . $i},
                    'image' => $shortcode->{'image_' . $i},
                    'topics' => $shortcode->{'topics_' . $i},
                    'comments' => $shortcode->{'comments_' . $i},
                    'account' => $shortcode->{'account_' . $i},
                ];
            }
        }

        return Theme::partial('shortcodes.from-community-forums.index', compact('shortcode', 'tabs'));
    });

    shortcode()->setAdminConfig('from-community-forums', function (array $attributes) {
        $teams = Team::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->pluck('name', 'id');

        return Theme::partial('shortcodes.from-community-forums.admin-config', compact('attributes', 'teams'));
    });
}
