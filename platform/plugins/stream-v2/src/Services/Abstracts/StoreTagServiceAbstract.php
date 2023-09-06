<?php

namespace Botble\Stream\Services\Abstracts;

use Botble\Stream\Models\Post;
use Botble\Stream\Repositories\Interfaces\TagInterface;
use Illuminate\Http\Request;

abstract class StoreTagServiceAbstract
{
    public function __construct(protected TagInterface $tagRepository)
    {
    }

    abstract public function execute(Request $request, Post $post): void;
}
