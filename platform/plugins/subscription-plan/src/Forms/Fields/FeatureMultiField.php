<?php

namespace Botble\SubscriptionPlan\Forms\Fields;

use Botble\Base\Forms\FormField;

class FeatureMultiField extends FormField
{
    protected function getTemplate(): string
    {
        return 'plugins/subscription-plan::features.features-multi';
    }
}
