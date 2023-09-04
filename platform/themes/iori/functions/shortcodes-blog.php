<?php

use Botble\Blog\Models\Category;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

if (is_plugin_active('blog')) {
    add_shortcode('from-our-blog', __('From our blog'), __('From our blog'), function (Shortcode $shortcode) {
        if (! $shortcode->type) {
            return null;
        }

        $numberOfDisplays = (int)$shortcode->limit ?: 5;

        $posts = match ($shortcode->type) {
            'featured' => get_featured_posts($numberOfDisplays),
            'recent' => get_recent_posts($numberOfDisplays),
            default => get_latest_posts($numberOfDisplays),
        };

        return Theme::partial('shortcodes.from-our-blog.index', compact('shortcode', 'posts'));
    });

    shortcode()->setAdminConfig('from-our-blog', function (array $attributes) {
        return Theme::partial('shortcodes.from-our-blog.admin-config', compact('attributes'));
    });

    add_shortcode('featured-post', __('Feature post'), __('Feature post'), function (Shortcode $shortcode) {
        Theme::asset()->container('footer')->usePath()->add('featured-post-js', 'js/featured-post.js');
        if (! $shortcode->category_ids) {
            return null;
        }

        $categoryIds = explode(',', $shortcode->category_ids);

        if (! $categoryIds) {
            return null;
        }

        $categories = Category::query()
            ->whereIn('id', $categoryIds)
            ->wherePublished()
            ->orderByDesc('created_at')
            ->orderBy('order')
            ->get();

        return Theme::partial('shortcodes.featured-post.index', compact('shortcode', 'categories'));
    });

    shortcode()->setAdminConfig('featured-post', function (array $attributes) {
        $categories = Category::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->orderBy('order')
            ->get();

        return Theme::partial('shortcodes.featured-post.admin-config', compact('attributes', 'categories'));
    });

    add_shortcode('post-category', __('Post category'), __('Post category'), function (Shortcode $shortcode) {
        if (empty($categoryId = $shortcode->category_id)) {
            return null;
        }

        $category = Category::query()
            ->where('id', $categoryId)
            ->wherePublished()
            ->with(['posts' => fn (BelongsToMany $query) => $query->limit((int) $shortcode->limit ?: 3)])
            ->first();

        if (! $category) {
            return null;
        }

        return Theme::partial('shortcodes.post-category.index', compact('shortcode', 'category'));
    });

    shortcode()->setAdminConfig('post-category', function (array $attributes) {
        $categories = Category::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->orderBy('order')
            ->get();

        return Theme::partial('shortcodes.post-category.admin-config', compact('attributes', 'categories'));
    });
}
