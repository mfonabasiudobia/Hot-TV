<?php

namespace Botble\Stream;

use Botble\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Botble\Menu\Repositories\Interfaces\MenuNodeInterface;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('palns');
        // Schema::dropIfExists('palns_translations');

        app(DashboardWidgetInterface::class)->deleteBy(['name' => 'widget_posts_recent']);

        Setting::delete([
            'Stream_post_schema_enabled',
            'Stream_post_schema_type',
        ]);
    }
}
