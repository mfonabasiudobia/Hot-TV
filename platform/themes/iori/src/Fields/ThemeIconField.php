<?php

namespace Theme\Iori\Fields;

use Botble\Base\Facades\Assets;
use Botble\Theme\Facades\Theme;
use Kris\LaravelFormBuilder\Fields\FormField;

class ThemeIconField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScriptsDirectly(Theme::asset()->url('js/icons-field.js'))
            ->addStylesDirectly(Theme::asset()->url('plugins/uicons-regular-rounded.css'));

        return Theme::getThemeNamespace() . '::partials.fields.icons-field';
    }
}
