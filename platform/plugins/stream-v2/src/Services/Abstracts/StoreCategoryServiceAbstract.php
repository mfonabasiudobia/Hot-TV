<?php

namespace Botble\Stream\Services\Abstracts;

use Botble\Stream\Models\Post;
use Botble\Stream\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

abstract class StoreCategoryServiceAbstract
{
    public function __construct(protected CategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, Post $post): void;
}
