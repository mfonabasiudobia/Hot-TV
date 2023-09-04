<?php

namespace ArchiElite\Career\Providers;

use ArchiElite\Career\Models\Career;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\SiteMapManager;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class CareerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        SlugHelper::registerModule(Career::class, 'Careers');
        SlugHelper::setPrefix(Career::class, 'careers');

        $this
            ->setNamespace('plugins/career')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->registerLanguage()
            ->loadMigrations()
            ->loadRoutes();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-career',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/career::career.name',
                'icon' => 'far fa-newspaper',
                'url' => route('careers.index'),
                'permissions' => ['careers.index'],
            ]);
        });

        $this->app
            ->register(EventServiceProvider::class)
            ->booted(fn () => SeoHelper::registerModule(Career::class));

        SiteMapManager::registerKey(['careers']);
    }

    protected function registerLanguage(): self
    {
        if (! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            return $this;
        }

        LanguageAdvancedManager::registerModule(Career::class, [
            'name',
            'location',
            'salary',
            'description',
            'content',
        ]);

        return $this;
    }
}
