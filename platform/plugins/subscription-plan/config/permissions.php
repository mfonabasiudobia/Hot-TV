<?php

return [
    [
        'name' => 'Subscription plans',
        'flag' => 'subscription-plan.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'subscription-plan.create',
        'parent_flag' => 'subscription-plan.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'subscription-plan.edit',
        'parent_flag' => 'subscription-plan.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'subscription-plan.destroy',
        'parent_flag' => 'subscription-plan.index',
    ],
    [
        'name' => 'Subscriptions',
        'flag' => 'subscriptions.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'subscriptions.create',
        'parent_flag' => 'subscriptions.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'subscriptions.edit',
        'parent_flag' => 'subscriptions.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'subscriptions.destroy',
        'parent_flag' => 'subscriptions.index',
    ],
    [
        'name' => 'Subscription features',
        'flag' => 'subscription-feature.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'subscription-feature.create',
        'parent_flag' => 'subscription-feature.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'subscription-feature.edit',
        'parent_flag' => 'subscription-feature.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'subscription-feature.destroy',
        'parent_flag' => 'subscription-feature.index',
    ],
];
