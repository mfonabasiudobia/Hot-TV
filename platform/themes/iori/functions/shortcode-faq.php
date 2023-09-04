<?php

use Botble\Faq\Contracts\Faq;
use Botble\Faq\FaqCollection;
use Botble\Faq\FaqItem;
use Botble\Faq\Models\FaqCategory;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;

if (is_plugin_active('faq')) {
    add_shortcode('faqs', __('FAQs'), __('FAQs'), function (Shortcode $shortcode) {
        if (! $shortcode->faq_category_ids) {
            return null;
        }

        $categoryIds = explode(',', $shortcode->faq_category_ids);

        if (! $categoryIds) {
            return null;
        }

        $faqCategories = FaqCategory::query()
            ->whereIn('id', $categoryIds)
            ->wherePublished()
            ->orderByDesc('created_at')
            ->with(['faqs'])
            ->get();

        if (setting('enable_faq_schema', 0)) {
            $schemaItems = new FaqCollection();

            foreach ($faqCategories as $faqCategory) {
                foreach ($faqCategory->faqs as $faq) {
                    $schemaItems->push(new FaqItem($faq->question, $faq->answer));
                }
            }

            app(Faq::class)->registerSchema($schemaItems);
        }

        return Theme::partial('shortcodes.faqs.index', compact('shortcode', 'faqCategories'));
    });

    shortcode()->setAdminConfig('faqs', function (array $attributes) {
        $faqCategories = FaqCategory::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->get();

        return Theme::partial('shortcodes.faqs.admin-config', compact('attributes', 'faqCategories'));
    });
}
