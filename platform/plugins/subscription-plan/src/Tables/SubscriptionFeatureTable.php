<?php

namespace Botble\SubscriptionPlan\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionFeature;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Botble\Table\DataTables;

class SubscriptionFeatureTable extends TableAbstract
{
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, SubscriptionFeature $subscriptionFeature)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $subscriptionFeature;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (!Auth::user()->hasAnyPermission(['subscription-feature.edit', 'subscription-feature.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (SubscriptionFeature $item) {
                if (!Auth::user()->hasPermission('subscription-feature.edit')) {
                    return BaseHelper::clean($item->name);
                }
                return Html::link(route('subscription-feature.edit', $item->getKey()), BaseHelper::clean($item->name));
            })
            ->editColumn('checkbox', function (SubscriptionFeature $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('description', function (SubscriptionFeature $item) {
                return $item->description;
            })
            ->editColumn('created_at', function (SubscriptionFeature $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function (SubscriptionFeature $item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function (SubscriptionFeature $item) {
                return $this->getOperations('subscription-feature.edit', 'subscription-feature.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
               'id',
               'name',
               'description',
               'created_at',
               'status',
           ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'description' => [
                'title' => trans('core/base::tables.description'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('subscription-feature.create'), 'subscription-feature.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('subscription-feature.deletes'), 'subscription-feature.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'date',
            ],
        ];
    }

    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
