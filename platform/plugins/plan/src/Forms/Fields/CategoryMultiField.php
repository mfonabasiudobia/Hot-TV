<?php

namespace Botble\Plan\Forms\Fields;

use Botble\Base\Forms\FormField;

class CategoryMultiField extends FormField
{
    protected function getTemplate(): string
    {
        return 'plugins/Plan::categories.categories-multi';
    }
}
