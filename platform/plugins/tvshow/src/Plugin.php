<?php

namespace Botble\Tvshow;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('tvshows');
        Schema::dropIfExists('tvshows_translations');
    }
}
