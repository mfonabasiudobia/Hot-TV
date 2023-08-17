<?php

namespace Botble\Stream\Providers;

use Botble\Api\Facades\ApiHelper;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Stream\Models\Stream;
use Botble\Stream\Repositories\Eloquent\StreamRepository;
use Botble\Stream\Repositories\Interfaces\StreamInterface;
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

class StreamServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(StreamInterface::class, function () {
            return new StreamRepository(new Stream());
        });
    }

    public function boot(): void
    {
        // SlugHelper::registerModule(Stream::class, 'Stream Streams');
        // SlugHelper::setPrefix(Stream::class, null, true);

        $this->setNamespace('plugins/stream')
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
        //     'stream-categories',
        //     'stream-tags',
        //     'stream-stream-((?:19|20|21|22)\d{2})-(0?[1-9]|1[012])',
        // ]);

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-stream',
                    'priority' => 3,
                    'parent_id' => null,
                    'name' => 'plugins/stream::base.menu_name',
                    'icon' => 'fa-regular fa-circle',
                    'url' => route('stream.index'),
                    'permissions' => ['stream.index'],
                ]);
        });

        // if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
        //     if (
        //         defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME') &&
        //         $this->app['config']->get('plugins.stream.general.use_language_v2')
        //     ) {
        //         LanguageAdvancedManager::registerModule(Stream::class, [
        //             'name',
        //             'description',
        //             'content',
        //         ]);
        //     } else {
        //         Language::registerModule([Stream::class]);
        //     }
        // }

        // $this->app->booted(function () {
        //     SeoHelper::registerModule([Stream::class]);

        //     $configKey = 'packages.revision.general.supported';
        //     config()->set($configKey, array_merge(config($configKey, []), [Stream::class]));

        //     $this->app->register(HookServiceProvider::class);
        // });

        // if (function_exists('shortcode')) {
        //     view()->composer([
        //         'plugins/stream::themes.post',
        //     ], function (View $view) {
        //         $view->withShortcodes();
        //     });
        // }
    }
}
