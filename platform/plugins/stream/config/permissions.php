<?php

return [
    [
        'name' => 'Streams',
        'flag' => 'stream.index',
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
    ],
];
