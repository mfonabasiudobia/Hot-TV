<?php

return [
    [
        'name' => 'Tvshows',
        'flag' => 'tvshow.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'tvshow.create',
        'parent_flag' => 'tvshow.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'tvshow.edit',
        'parent_flag' => 'tvshow.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'tvshow.destroy',
        'parent_flag' => 'tvshow.index',
    ],
];
