<?php

namespace Botble\Stream\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseQueryBuilder;
use Botble\Stream\Models\Stream;
use Botble\Stream\Repositories\Interfaces\StreamInterface;
use Botble\Language\Facades\Language;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class StreamRepository extends RepositoriesAbstract implements StreamInterface
{
  

  

    public function getSearch(
        string|null $keyword,
        int $limit = 10,
        int $paginate = 10
    ): Collection|LengthAwarePaginator {
        $data = $this->model
            ->with('slugable')
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('created_at', 'desc');

        $data = $this->search($data, $keyword);

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getAllStreams(
        int $perPage = 12,
        bool $active = true,
        array $with = ['slugable']
    ): Collection|LengthAwarePaginator {
        $data = $this->model
            ->with($with)
            ->orderBy('created_at', 'desc');

        if ($active) {
            $data = $data->where('status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }



    public function getFilters(array $filters): Collection|LengthAwarePaginator
    {
        $data = $this->originalModel;

 
        if ($filters['exclude'] !== null) {
            $data = $data->whereNotIn('id', array_filter((array)$filters['exclude']));
        }

        if ($filters['include'] !== null) {
            $data = $data->whereNotIn('id', array_filter((array)$filters['include']));
        }

        
        if ($filters['search'] !== null) {
            $data = $this->search($data, $filters['search']);
        }

        $orderBy = Arr::get($filters, 'order_by', 'updated_at');
        $order = Arr::get($filters, 'order', 'desc');

        $data = $data
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($data)->paginate((int)$filters['per_page']);
    }

    protected function search(BaseQueryBuilder|Builder $model, string $keyword): BaseQueryBuilder|Builder
    {
        if (! $model instanceof BaseQueryBuilder) {
            return $model;
        }

        if (
            is_plugin_active('language') &&
            is_plugin_active('language-advanced') &&
            Language::getCurrentLocale() != Language::getDefaultLocale()
        ) {
            return $model
                ->whereHas('translations', function (BaseQueryBuilder $query) use ($keyword) {
                    $query
                        ->addSearch('name', $keyword, false, false)
                        ->addSearch('description', $keyword, false);
                });
        }

        return $model
            ->where(function (BaseQueryBuilder $query) use ($keyword) {
                $query
                    ->addSearch('name', $keyword, false, false)
                    ->addSearch('description', $keyword, false);
            });
    }
}
