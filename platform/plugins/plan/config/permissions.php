<?php

return [
    [
        'name' => 'Plan',
        'flag' => 'plugins.plan',
    ],
    [
        'name' => 'Plans',
        'flag' => 'plan.index',
        'parent_flag' => 'plugins.plan',
    ],
    [
        'name' => 'Create',
        'flag' => 'plan.create',
        'parent_flag' => 'plan.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'plan.edit',
        'parent_flag' => 'plan.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'plan.destroy',
        'parent_flag' => 'plan.index',
    ]
];
