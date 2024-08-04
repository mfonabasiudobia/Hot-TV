<?php

namespace Botble\SubscriptionPlan\Providers;

use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Supports\ServiceProvider;
use Botble\SubscriptionPlan\Repositories\Eloquent\SubscriptionFeaturesRepository;
use Botble\SubscriptionPlan\Repositories\Interfaces\SubscriptionFeaturesInterface;
use Botble\SubscriptionPlan\Models\SubscriptionFeature;
use Illuminate\Routing\Events\RouteMatched;
use Botble\Theme\Facades\SiteMapManager;
use Botble\Slug\Facades\SlugHelper;

class SubscriptionPlanServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(SubscriptionFeaturesInterface::class, function () {
            return new SubscriptionFeaturesRepository(new SubscriptionFeature());
        });
    }

    public function boot(): void
    {

        SlugHelper::registerModule(SubscriptionFeature::class, 'Features');
        SlugHelper::setPrefix(SubscriptionFeature::class, 'feature', true);


        $this
            ->setNamespace('plugins/subscription-plan')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes();

        $this->app->register(EventServiceProvider::class);

        SiteMapManager::registerKey([
            'features',
        ]);

        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(\Botble\SubscriptionPlan\Models\Subscritions::class, [
                'name',
            ]);
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(SubscriptionPlan::class, [
                'name',
            ]);
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(\Botble\SubscriptionPlan\Models\SubscriptionFeature::class, [
                'name',
            ]);
        }

        $this->app['events']->listen(RouteMatched::class, function () {
            

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-subscription-plan',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/subscription-plan::subscription-plan.name',
                'icon' => 'fa fa-list',
                'url' => route('subscription-plan.index'),
                'permissions' => ['subscription-plan.index'],
            ]);

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-plans',
                'priority' => 0,
                'parent_id' => 'cms-plugins-subscription-plan',
                'name' => 'Plans',
                'icon' => null,
                'url' => route('subscription-plan.index'),
                'permissions' => ['subscription-plan.index'],
            ]);

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-subscriptions',
                'priority' => 1,
                'parent_id' => 'cms-plugins-subscription-plan',
                'name' => 'plugins/subscription-plan::subscriptions.name',
                'icon' => null,
                'url' => route('subscriptions.index'),
                'permissions' => ['subscriptions.index'],
            ]);
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-subscription-feature',
                'priority' => 2,
                'parent_id' => 'cms-plugins-subscription-plan',
                'name' => 'plugins/subscription-plan::subscription-feature.name',
                'icon' => null,
                'url' => route('subscription-feature.index'),
                'permissions' => ['subscription-feature.index'],
            ]);
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
