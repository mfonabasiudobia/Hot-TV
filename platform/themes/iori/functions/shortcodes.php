<?php

use Botble\Ecommerce\Enums\CustomerStatusEnum;
use Botble\Ecommerce\Models\Customer;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Theme\Supports\Youtube;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    // add_shortcode('hero-banner', __('Hero banner'), __('Hero banner'), function (Shortcode $shortcode) {
    //     if ($shortcode->youtube_video_url) {
    //         $shortcode->youtube_video_id = $shortcode->youtube_video_url ? Youtube::getYoutubeVideoID($shortcode->youtube_video_url) : null;
    //     }

    //     $customers = collect();

    //     if (is_plugin_active('ecommerce') && $shortcode->customer_ids) {
    //         $customerIds = explode(',', $shortcode->customer_ids);

    //         if ($customerIds) {
    //             $customers = Customer::query()
    //                 ->where('status', CustomerStatusEnum::ACTIVATED)
    //                 ->whereIn('id', $customerIds)
    //                 ->get();
    //         }
    //     }

    //     return Theme::partial('shortcodes.hero-banner.index', compact('shortcode', 'customers'));
    // });

    // shortcode()->setAdminConfig('hero-banner', function (array $attributes) {
    //     $customers = [];

    //     if (is_plugin_active('ecommerce')) {
    //         $customers = Customer::query()
    //             ->where('status', CustomerStatusEnum::ACTIVATED)
    //             ->get();
    //     }

    //     return Theme::partial('shortcodes.hero-banner.admin-config', compact('attributes', 'customers'));
    // });

    // add_shortcode('intro-video', __('Intro video'), __('Intro video'), function (Shortcode $shortcode) {
    //     $shortcode->youtube_video_id = $shortcode->youtube_video_url ? Youtube::getYoutubeVideoID($shortcode->youtube_video_url) : null;

    //     return Theme::partial('shortcodes.intro-video.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('intro-video', function (array $attributes) {
    //     return Theme::partial('shortcodes.intro-video.admin-config', compact('attributes'));
    // });

    // add_shortcode('why-choose-us', __('Why Choose Us'), __('Why Choose Us'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.why-choose-us.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('why-choose-us', function (array $attributes) {
    //     return Theme::partial('shortcodes.why-choose-us.admin-config', compact('attributes'));
    // });

    // add_shortcode('get-in-touch', __('Get In Touch'), __('Get In Touch'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.get-in-touch.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('get-in-touch', function (array $attributes) {
    //     return Theme::partial('shortcodes.get-in-touch.admin-config', compact('attributes'));
    // });

    // add_shortcode('how-to-start', __('How to start'), __('How to start'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.how-to-start.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('how-to-start', function (array $attributes) {
    //     return Theme::partial('shortcodes.how-to-start.admin-config', compact('attributes'));
    // });

    // add_shortcode('marketing-features', __('Marketing Features'), __('Marketing Features'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.marketing-features.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('marketing-features', function (array $attributes) {
    //     return Theme::partial('shortcodes.marketing-features.admin-config', compact('attributes'));
    // });

    // add_shortcode('what-we-do', __('What we do'), __('What we do'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.what-we-do.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('what-we-do', function (array $attributes) {
    //     return Theme::partial('shortcodes.what-we-do.admin-config', compact('attributes'));
    // });

    // add_shortcode('site-statistics', __('Site Statistics'), __('Site Statistics'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.site-statistics.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('site-statistics', function (array $attributes) {
    //     return Theme::partial('shortcodes.site-statistics.admin-config', compact('attributes'));
    // });

    // add_shortcode('how-it-work', __('How it work'), __('How it work'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.how-it-work.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('how-it-work', function (array $attributes) {
    //     return Theme::partial('shortcodes.how-it-work.admin-config', compact('attributes'));
    // });

    // add_shortcode('who-are-you', __('Who are you'), __('Who are you'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.who-are-you.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('who-are-you', function (array $attributes) {
    //     return Theme::partial('shortcodes.who-are-you.admin-config', compact('attributes'));
    // });

    // add_shortcode('box-story', __('Box Story'), __('Box Story'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.box-story.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('box-story', function (array $attributes) {
    //     return Theme::partial('shortcodes.box-story.admin-config', compact('attributes'));
    // });

    // add_shortcode('information', __('Information'), __('Information'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.information.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('information', function (array $attributes) {
    //     return Theme::partial('shortcodes.information.admin-config', compact('attributes'));
    // });

    // add_shortcode('about-product', __('About Product'), __('About Product'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.about-product.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('about-product', function (array $attributes) {
    //     return Theme::partial('shortcodes.about-product.admin-config', compact('attributes'));
    // });

    // add_shortcode('branding-block', __('Branding block'), __('Branding block'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.branding-block.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('branding-block', function (array $attributes) {
    //     return Theme::partial('shortcodes.branding-block.admin-config', compact('attributes'));
    // });

    // add_shortcode('business-strategy', __('Business strategy'), __('Business strategy'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.business-strategy.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('business-strategy', function (array $attributes) {
    //     return Theme::partial('shortcodes.business-strategy.admin-config', compact('attributes'));
    // });

    // add_shortcode('grow-business', __('Grow business'), __('Grow business'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.grow-business.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('grow-business', function (array $attributes) {
    //     return Theme::partial('shortcodes.grow-business.admin-config', compact('attributes'));
    // });

    // add_shortcode('connect-with-us', __('Connect with us'), __('Connect with us'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.connect-with-us.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('connect-with-us', function (array $attributes) {
    //     return Theme::partial('shortcodes.connect-with-us.admin-config', compact('attributes'));
    // });

    // add_shortcode('featured-services', __('Featured services'), __('Featured service'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.featured-services.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('featured-services', function (array $attributes) {
    //     return Theme::partial('shortcodes.featured-services.admin-config', compact('attributes'));
    // });

    // add_shortcode('coming-soon', __('Coming soon'), __('Coming soon'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.coming-soon.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('coming-soon', function (array $attributes) {
    //     return Theme::partial('shortcodes.coming-soon.admin-config', compact('attributes'));
    // });

    // add_shortcode('technology-block', __('Technology block'), __('Technology block'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.technology-block.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('technology-block', function (array $attributes) {
    //     return Theme::partial('shortcodes.technology-block.admin-config', compact('attributes'));
    // });

    // add_shortcode('everything-will-become-one', __('Everything will become One'), __('Everything will become One'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.everything-will-become-one.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('everything-will-become-one', function (array $attributes) {
    //     return Theme::partial('shortcodes.everything-will-become-one.admin-config', compact('attributes'));
    // });

    // add_shortcode('hero-banner-with-site-statistics', __('Hero banner with site statistics'), __('Hero banner with site statistics'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.hero-banner-with-site-statistics.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('hero-banner-with-site-statistics', function (array $attributes) {
    //     return Theme::partial('shortcodes.hero-banner-with-site-statistics.admin-config', compact('attributes'));
    // });

    // add_shortcode('explore-network', __('Explore network'), __('Explore network'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.explore-network.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('explore-network', function (array $attributes) {
    //     return Theme::partial('shortcodes.explore-network.admin-config', compact('attributes'));
    // });

    // add_shortcode('take-the-control', __('Tab the control'), __('Tab the control'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.take-the-control.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('take-the-control', function (array $attributes) {
    //     return Theme::partial('shortcodes.take-the-control.admin-config', compact('attributes'));
    // });

    // add_shortcode('step-block', __('Step block'), __('Step block'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.step-block.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('step-block', function (array $attributes) {
    //     return Theme::partial('shortcodes.step-block.admin-config', compact('attributes'));
    // });

    // add_shortcode('banner-slider', __('Banner slider'), __('Banner slider'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.banner-slider.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('banner-slider', function (array $attributes) {
    //     return Theme::partial('shortcodes.banner-slider.admin-config', compact('attributes'));
    // });

    // add_shortcode('have-a-question', __('Have a question'), __('Have a question'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.have-a-question.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('have-a-question', function (array $attributes) {
    //     return Theme::partial('shortcodes.have-a-question.admin-config', compact('attributes'));
    // });

    // add_shortcode('dual-intro-video', __('Dual intro video'), __('Dual intro video'), function (Shortcode $shortcode) {
    //     $tabs = [];
    //     $quantity = min((int) $shortcode->quantity, 20);
    //     if ($quantity) {
    //         for ($i = 1; $i <= $quantity; $i++) {
    //             $tabs[] = [
    //                 'title' => $shortcode->{'title_' . $i},
    //                 'subtitle' => $shortcode->{'subtitle_' . $i},
    //                 'description' => $shortcode->{'description_' . $i},
    //                 'image' => $shortcode->{'image_' . $i},
    //                 'youtube_video_id' => $shortcode->{'youtube_video_url_' . $i} ? Youtube::getYoutubeVideoID($shortcode->{'youtube_video_url_' . $i}) : null,
    //                 'button_label' => $shortcode->{'button_label_' . $i},
    //             ];
    //         }
    //     }

    //     return Theme::partial('shortcodes.dual-intro-video.index', compact('shortcode', 'tabs'));
    // });

    // shortcode()->setAdminConfig('dual-intro-video', function (array $attributes) {
    //     return Theme::partial('shortcodes.dual-intro-video.admin-config', compact('attributes'));
    // });

    // add_shortcode('compare-plans', __('Compare plans'), __('Compare plans'), function (Shortcode $shortcode) {
    //     $tabs = [];
    //     $quantity = min((int) $shortcode->quantity, 20);
    //     if ($quantity) {
    //         for ($i = 1; $i <= $quantity; $i++) {
    //             $tabs[] = [
    //                 'title' => $shortcode->{'title_' . $i},
    //                 'free' => $shortcode->{'free_' . $i},
    //                 'standard' => $shortcode->{'standard_' . $i},
    //                 'business' => $shortcode->{'business_' . $i},
    //                 'enterprise' => $shortcode->{'enterprise_' . $i},
    //             ];
    //         }
    //     }

    //     return Theme::partial('shortcodes.compare-plans.index', compact('shortcode', 'tabs'));
    // });

    // shortcode()->setAdminConfig('compare-plans', function (array $attributes) {
    //     return Theme::partial('shortcodes.compare-plans.admin-config', compact('attributes'));
    // });

    // add_shortcode('banner-hero-with-search', __('Banner hero with search'), __('Banner hero with search'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.banner-hero-with-search.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('banner-hero-with-search', function (array $attributes) {
    //     return Theme::partial('shortcodes.banner-hero-with-search.admin-config', compact('attributes'));
    // });

    // add_shortcode('term-and-conditions', __('Term and Conditions'), __('Term and Conditions'), function (Shortcode $shortcode) {
    //     $tabs = [];
    //     $quantity = min((int) $shortcode->quantity, 20);
    //     if ($quantity) {
    //         for ($i = 1; $i <= $quantity; $i++) {
    //             $tabs[] = [
    //                 'title' => $shortcode->{'title_' . $i},
    //                 'description' => $shortcode->{'description_' . $i},
    //             ];
    //         }
    //     }

    //     return Theme::partial('shortcodes.term-and-conditions.index', compact('shortcode', 'tabs'));
    // });

    // shortcode()->setAdminConfig('term-and-conditions', function (array $attributes) {
    //     return Theme::partial('shortcodes.term-and-conditions.admin-config', compact('attributes'));
    // });

    // add_shortcode('contact-page-banner', __('Contact Page Banner'), __('Contact Page Banner'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.contact-page-banner.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('contact-page-banner', function (array $attributes) {
    //     return Theme::partial('shortcodes.contact-page-banner.admin-config', compact('attributes'));
    // });

    // add_shortcode('contact-information', __('Contact Information'), __('Contact Information'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.contact-information.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('contact-information', function (array $attributes) {
    //     return Theme::partial('shortcodes.contact-information.admin-config', compact('attributes'));
    // });

    // add_shortcode('everything-will-become-one', __('Everything will become one'), __('Everything will become one'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.everything-will-become-one.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('everything-will-become-one', function (array $attributes) {
    //     return Theme::partial('shortcodes.everything-will-become-one.admin-config', compact('attributes'));
    // });

    // add_shortcode('career-banner', __('Career banner'), __('Career banner'), function (Shortcode $shortcode) {
    //     return Theme::partial('shortcodes.career-banner.index', compact('shortcode'));
    // });

    // shortcode()->setAdminConfig('career-banner', function (array $attributes) {
    //     return Theme::partial('shortcodes.career-banner.admin-config', compact('attributes'));
    // });

    /*NEW SHORT CODES ARE ADDED HERE*/
    add_shortcode('faq', __('Frequently Asked Questions'), __('Frequently Asked Questions'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.faq.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('faq', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.faq.admin-config', compact('attributes'));
    });

    add_shortcode('faq-list', __('Faq List'), __('Faq List'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.faq-list.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('faq-list', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.faq-list.admin-config', compact('attributes'));
    });

    add_shortcode('hero-section', __('Hero Section'), __('Hero Section'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.hero-section.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('hero-section', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.hero-section.admin-config', compact('attributes'));
    });

    add_shortcode('recently-watched', __('Recently Watched'), __('Recently Watched'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.recently-watched.index', compact('shortcode'));
    });
    
    shortcode()->setAdminConfig('recently-watched', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.recently-watched.admin-config', compact('attributes'));
    });

    add_shortcode('pedicab-stream', __('Pedicab Stream'), __('Pedicab Stream'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.pedicab-streams.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('pedicab-stream', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.pedicab-streams.admin-config', compact('attributes'));
    });

    add_shortcode('recommended-tv-shows', __('Recommended Tv Shows'), __('Recommended Tv Shows'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.recommended-tv-shows.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('recommended-tv-shows', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.recommended-tv-shows.admin-config', compact('attributes'));
    });

    add_shortcode('most-viewed', __('Most Viewed/Past Streams'), __('Most Viewed/Past Streams'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.most-viewed.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('most-viewed', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.most-viewed.admin-config', compact('attributes'));
    });


    add_shortcode('popular-podcast', __('Popular Podcasts'), __('Popular Podcasts'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.popular-podcasts.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('popular-podcast', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.popular-podcasts.admin-config', compact('attributes'));
    });

    add_shortcode('pricing', __('Pricing'), __('Pricing'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.new-shortcodes.pricing.index', compact('shortcode'));
    });

    shortcode()->setAdminConfig('pricing', function (array $attributes) {
        return Theme::partial('shortcodes.new-shortcodes.pricing.admin-config', compact('attributes'));
    });

    /*END OF NEW SHORT CODES*/
    add_shortcode('what-we-offer', __('What we offer'), __('What we offer'), function (Shortcode $shortcode) {
        $style = in_array($shortcode->style, ['style-1', 'style-2', 'style-3', 'style-4']) ? $shortcode->style : 'style-1';

        $tabs = [];
        $quantity = min((int) $shortcode->quantity, 20);

        if ($quantity) {
            for ($i = 1; $i <= $quantity; $i++) {
                $tabs[] = [
                    'title' => $shortcode->{'title_' . $i},
                    'description' => $shortcode->{'description_' . $i},
                    'image' => $shortcode->{'image_' . $i},
                    'logo' => $shortcode->{'logo_' . $i},
                    'label' => $shortcode->{'label_' . $i},
                    'action' => $shortcode->{'action_' . $i},
                ];
            }
        }

        return Theme::partial(
            "shortcodes.what-we-offer.styles.$style",
            compact('shortcode', 'style', 'tabs')
        );
    });

    shortcode()->setAdminConfig('what-we-offer', function (array $attributes) {
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'description' => [
                'title' => __('Description'),
            ],
            'image' => [
                'type' => 'image',
                'title' => __('Image'),
            ],
            'logo' => [
                'type' => 'image',
                'title' => __('Logo'),
            ],
            'label' => [
                'title' => __('Label'),
            ],
            'action' => [
                'title' => __('Action'),
            ],
        ];

        return Theme::partial('shortcodes.what-we-offer.admin-config', compact('attributes', 'fields'));
    });

    add_shortcode('choose-to-the-plan', __('Choose to the plan'), __('Choose to the plan'), function (Shortcode $shortcode) {
        $tabs = [];
        $quantity = min((int)$shortcode->quantity, 20) ?: 6;
        if ($quantity) {
            for ($i = 1; $i <= $quantity; $i++) {
                if ($title = $shortcode->{'title_' . $i}) {
                    $isActive = $shortcode->{'active_' . $i} === 'yes';
                    $tabs[] = [
                        'title' => $title,
                        'subtitle' => $shortcode->{'subtitle_' . $i},
                        'payment_cycle' => $shortcode->{'payment_cycle_' . $i},
                        'icon_image' => $shortcode->{'icon_image_' . $i},
                        'month_price' => $shortcode->{'month_price_' . $i},
                        'year_price' => $shortcode->{'year_price_' . $i},
                        'button_label' => $shortcode->{'button_label_' . $i},
                        'button_url' => $shortcode->{'button_url_' . $i},
                        'checked' => array_filter(explode(';', $shortcode->{'checked_' . $i})),
                        'uncheck' => array_filter(explode(';', $shortcode->{'uncheck_' . $i})),
                        'active' => $isActive,
                    ];
                }
            }
        }
        if ($tabs) {
            $active = Arr::first($tabs, function ($value) {
                return $value['active'] == true;
            });

            if (! $active) {
                $tabs[0]['active'] = true;
            }
        }

        $styleBg = ['bg-fourth-bg', 'bg-first-bg', 'bg-second-bg', 'bg-fifth-bg'];
        $style = in_array($shortcode->style, ['style-1', 'style-2']) ? $shortcode->style : 'style-1';

        return Theme::partial(
            "shortcodes.choose-to-the-plan.styles.$style",
            compact('shortcode', 'tabs', 'styleBg')
        );
    });

    shortcode()->setAdminConfig('choose-to-the-plan', function (array $attributes) {
        $fields = [
            'title' => [
                'title' => __('Title'),
            ],
            'subtitle' => [
                'title' => __('Subtitle'),
            ],
            'payment_cycle' => [
                'title' => __('Payment cycle'),
            ],
            'icon_image' => [
                'type' => 'image',
                'title' => __('Icon image'),
            ],
            'month_price' => [
                'title' => __('Month price'),
            ],
            'year_price' => [
                'title' => __('Year price'),
            ],
            'button_label' => [
                'title' => __('Button label'),
                'placeholder' => __('Button label'),
            ],
            'button_url' => [
                'title' => __('Button URL'),
                'placeholder' => __('Button URL'),
            ],
            'checked' => [
                'title' => __('Checked list'),
                'placeholder' => __('Enter a list with checked, separated by semicolons'),
            ],
            'uncheck' => [
                'title' => __('Uncheck list'),
                'placeholder' => __('Enter a list with unchecked, separated by semicolons'),
            ],
            'active' => [
                'type' => 'checkbox',
                'title' => __('Is active?'),
            ],
        ];

        return Html::style('vendor/core/core/base/libraries/tagify/tagify.css') .
            Html::script('vendor/core/core/base/libraries/tagify/tagify.js') .
            Html::script('vendor/core/core/base/js/tags.js') .
            Theme::partial('shortcodes.choose-to-the-plan.admin-config', compact('attributes', 'fields'));
    });
});
