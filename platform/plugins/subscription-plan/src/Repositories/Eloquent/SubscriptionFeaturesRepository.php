<?php

namespace Botble\SubscriptionPlan\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Repositories\Interfaces\SubscriptionFeaturesInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Collection;


class SubscriptionFeaturesRepository extends RepositoriesAbstract implements SubscriptionFeaturesInterface
{
    public function getFeatures(): Collection
    {
        $data = $this->model->where('status', BaseStatusEnum::PUBLISHED);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getAllFeaturesWithChildren(array $condition = [], array $with = [], array $select = ['*']): Collection
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}