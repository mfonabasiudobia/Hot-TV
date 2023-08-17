<?php

return [
    [
        'name' => 'Stream',
        'flag' => 'plugins.stream',
    ],
    [
        'name' => 'Plans',
        'flag' => 'stream.index',
        'parent_flag' => 'plugins.stream',
    ],
    [
        'name' => 'Create',
        'flag' => 'stream.create',
        'parent_flag' => 'stream.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'stream.edit',
        'parent_flag' => 'stream.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'stream.destroy',
        'parent_flag' => 'stream.index',
    ]
];
