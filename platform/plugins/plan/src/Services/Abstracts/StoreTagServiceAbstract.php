<?php

namespace Botble\Plan\Services\Abstracts;

use Botble\Plan\Models\Post;
use Botble\Plan\Repositories\Interfaces\TagInterface;
use Illuminate\Http\Request;

abstract class StoreTagServiceAbstract
{
    public function __construct(protected TagInterface $tagRepository)
    {
    }

    abstract public function execute(Request $request, Post $post): void;
}
