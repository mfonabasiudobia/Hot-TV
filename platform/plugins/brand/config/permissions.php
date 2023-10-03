<?php

return [
    [
        'name' => 'Brands',
        'flag' => 'brand.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'brand.create',
        'parent_flag' => 'brand.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'brand.edit',
        'parent_flag' => 'brand.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'brand.destroy',
        'parent_flag' => 'brand.index',
    ],
];
