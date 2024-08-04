<?php

namespace Botble\SubscriptionPlan\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface SubscriptionFeaturesInterface extends RepositoryInterface
{
    public function getFeatures(): Collection;
    public function getAllFeaturesWithChildren(array $condition = [], array $with = [], array $select = ['*']): Collection;
}