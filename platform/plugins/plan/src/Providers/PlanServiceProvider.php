<?php

namespace Botble\Plan\Providers;

use Botble\Api\Facades\ApiHelper;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Plan\Models\Plan;
use Botble\Plan\Repositories\Eloquent\PlanRepository;
use Botble\Plan\Repositories\Interfaces\PlanInterface;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Shortcode\View\View;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\SiteMapManager;
use Illuminate\Routing\Events\RouteMatched;

/**
 * @since 02/07/2016 09:50 AM
 */

class PlanServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(PlanInterface::class, function () {
            return new PlanRepository(new Plan());
        });
    }

    public function boot(): void
    {
        // SlugHelper::registerModule(Plan::class, 'Plan Plans');
        // SlugHelper::setPrefix(Plan::class, null, true);

        $this->setNamespace('plugins/plan')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadMigrations()
            ->publishAssets();

        if (ApiHelper::enabled()) {
            $this->loadRoutes(['api']);
        }

        $this->app->register(EventServiceProvider::class);

        // SiteMapManager::registerKey([
        //     'plan-categories',
        //     'plan-tags',
        //     'plan-plan-((?:19|20|21|22)\d{2})-(0?[1-9]|1[012])',
        // ]);

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-plan',
                    'priority' => 3,
                    'parent_id' => null,
                    'name' => 'plugins/plan::base.menu_name',
                    'icon' => 'fa-regular fa-circle',
                    'url' => route('plan.index'),
                    'permissions' => ['plan.index'],
                ]);
        });

        // if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
        //     if (
        //         defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME') &&
        //         $this->app['config']->get('plugins.plan.general.use_language_v2')
        //     ) {
        //         LanguageAdvancedManager::registerModule(Plan::class, [
        //             'name',
        //             'description',
        //             'content',
        //         ]);
        //     } else {
        //         Language::registerModule([Plan::class]);
        //     }
        // }

        // $this->app->booted(function () {
        //     SeoHelper::registerModule([Plan::class]);

        //     $configKey = 'packages.revision.general.supported';
        //     config()->set($configKey, array_merge(config($configKey, []), [Plan::class]));

        //     $this->app->register(HookServiceProvider::class);
        // });

        // if (function_exists('shortcode')) {
        //     view()->composer([
        //         'plugins/plan::themes.post',
        //     ], function (View $view) {
        //         $view->withShortcodes();
        //     });
        // }
    }
}
