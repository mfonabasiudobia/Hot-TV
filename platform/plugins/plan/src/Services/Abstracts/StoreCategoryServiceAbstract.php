<?php

namespace Botble\Plan\Services\Abstracts;

use Botble\Plan\Models\Post;
use Botble\Plan\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

abstract class StoreCategoryServiceAbstract
{
    public function __construct(protected CategoryInterface $categoryRepository)
    {
    }

    abstract public function execute(Request $request, Post $post): void;
}
