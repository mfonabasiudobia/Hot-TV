<?php

namespace Botble\SubscriptionPlan;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('subscription_plans');
        Schema::dropIfExists('subscription_plans_translations');
        
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscritions_translations');

        Schema::dropIfExists('subscription_subscrption_feature');
        Schema::dropIfExists('subscription_features');
        Schema::dropIfExists('subscription_features_translations');
        Schema::dropIfExists('subscription_orders');
    }
}
