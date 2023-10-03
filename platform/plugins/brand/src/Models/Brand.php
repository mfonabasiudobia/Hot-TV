<?php

namespace Botble\Brand\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Brand extends BaseModel
{
    protected $table = 'brands';

    protected $fillable = [
        'name',
        'image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];

    public function scopePublished($q){
        return $q->where('status', 'published');
    }
}
