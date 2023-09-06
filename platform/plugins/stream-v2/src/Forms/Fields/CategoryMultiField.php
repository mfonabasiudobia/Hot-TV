<?php

namespace Botble\Stream\Forms\Fields;

use Botble\Base\Forms\FormField;

class CategoryMultiField extends FormField
{
    protected function getTemplate(): string
    {
        return 'plugins/Stream::categories.categories-multi';
    }
}
