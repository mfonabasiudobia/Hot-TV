<?php

namespace ArchiElite\AiWriter\Providers;

use ArchiElite\AiWriter\AiWriter;
use ArchiElite\AiWriter\Contracts\AiWriter as AiWriterContract;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AiWriterServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->singleton(
            AiWriterContract::class,
            fn () => new AiWriter(
                setting('ai_writer_openai_key'),
                setting('ai_writer_openai_default_model'),
            )
        );
    }

    public function boot(): void
    {
        $this->setNamespace('plugins/ai-writer')
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-ai-writer',
                'priority' => 9,
                'parent_id' => 'cms-core-settings',
                'name' => 'plugins/ai-writer::ai-writer.name',
                'icon' => null,
                'url' => route('ai-writer.settings'),
                'permissions' => ['ai-writer.settings'],
            ]);
        });

        $this->app->register(HookServiceProvider::class);
    }
}
