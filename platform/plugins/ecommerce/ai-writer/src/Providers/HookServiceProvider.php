<?php

namespace ArchiElite\AiWriter\Providers;

use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_FORM_EDITOR_BUTTONS, function (): View|null {
            if (! is_in_admin(true)) {
                return null;
            }

            if (BaseHelper::getRichEditor() !== 'ckeditor') {
                return null;
            }

            Assets::addScriptsDirectly(
                config(sprintf('core.base.general.editor.%s.js', BaseHelper::getRichEditor()))
            )
                ->addScriptsDirectly([
                    'vendor/core/core/base/js/editor.js',
                    'vendor/core/plugins/ai-writer/js/ai-writer.js',
                ]);

            return view('plugins/ai-writer::partials.action');
        }, 30);
    }
}
