<?php
namespace Botble\SubscriptionPlan\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Botble\Shortcode\Compilers\Shortcode;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // if(function_exists('generate_shortcode')) {
        //     generate_shortcode('subscription-plan', ['foo' => 'bar', 'abc' => 'xyz']);
        // }
        if (function_exists('add_shortcode')) {
            add_shortcode(
                'subscription-plan',
                trans('plugins/subscription-plan::base.short_code_name'),
                trans('plugins/subscription-plan::base.short_code_description'),
                [$this, 'renderSubscriptionPlans']
            );

            shortcode()->setAdminConfig('subscription-plan', [$this, 'subscriptionPlanConfig']);
            // shortcode()->setAdminConfig('subscription-plan', function ($attributes, $content) {
            //     return view('plugins/blog::partials.posts-short-code-admin-config', compact('attributes', 'content'))
            //         ->render();
            // });
        }
    }

    public function renderSubscriptionPlans(Shortcode $shortcode): array|string
    {
        
        $plans = get_all_subscrition_plans();
       
        $view = 'plugins/subscription-plan::themes.templates.plans';
        //$themeView = Theme::getThemeNamespace() . '::views.templates.posts';

        // if (view()->exists($themeView)) {
        //     $view = $themeView;
        // }

        return view($view, compact('plans'))->render();
    }

    public function subscriptionPlanConfig(array $attributes, string|null $content): string
    {
        $subscriptionPlans = SubscriptionPlan::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->pluck('name')
            ->all();

        return view('plugins/block::partials.short-code-admin-config', compact('subscriptionPlans', 'attributes', 'content'))
            ->render();
    }
}

