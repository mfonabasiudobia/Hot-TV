<?php

namespace Botble\Stream\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Stream extends BaseModel
{
    protected $table = 'streams';

    protected $guarded = [];
    
}
