<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\SortItemsWithChildrenHelper;
use Botble\SubscriptionPlan\Repositories\Interfaces\SubscriptionFeaturesInterface;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;

if (! function_exists('get_features_with_children')) {
    function get_features_with_children(): array
    {
        $categories = app(SubscriptionFeaturesInterface::class)
            ->getAllFeaturesWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name']);

        return app(SortItemsWithChildrenHelper::class)
            ->setChildrenProperty('child_cats')
            ->setItems($categories)
            ->sort();
    }
}

if (! function_exists('get_all_subscrition_plans')) {
    function get_all_subscrition_plans()
    {
        $subscriptionPlans = SubscriptionPlan::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->get();

        return $subscriptionPlans;
    }
}

