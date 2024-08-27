<?php

namespace Botble\Gallery\Models;

use Botble\Base\Models\BaseModel;

class GalleryMeta extends BaseModel
{
    protected $table = 'gallery_meta';

    protected $fillable = [
        'images',
        'reference_id',
        'reference_type'

    ];

    protected $casts = [
        'images' => 'json',
    ];
}
