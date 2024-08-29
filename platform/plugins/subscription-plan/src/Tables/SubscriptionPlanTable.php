<?php

namespace Botble\SubscriptionPlan\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Botble\Table\DataTables;

class SubscriptionPlanTable extends TableAbstract
{
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, SubscriptionPlan $subscriptionPlan)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $subscriptionPlan;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (!Auth::user()->hasAnyPermission(['subscription-plan.edit', 'subscription-plan.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (SubscriptionPlan $item) {
                if (!Auth::user()->hasPermission('subscription-plan.edit')) {
                    return BaseHelper::clean($item->name);
                }
                return Html::link(route('subscription-plan.edit', $item->getKey()), BaseHelper::clean($item->name));
            })
            ->editColumn('checkbox', function (SubscriptionPlan $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('trail', function (SubscriptionPlan $item) {
                return $item->trail == 1 ? 'Enabled' : 'Disabled';
            })
            ->editColumn('trail_period', function (SubscriptionPlan $item) {
                return $item->trail_period;
            })
            ->editColumn('created_at', function (SubscriptionPlan $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function (SubscriptionPlan $item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function (SubscriptionPlan $item) {
                return $this->getOperations('subscription-plan.edit', 'subscription-plan.destroy', $item);
            });
            // ->editColumn('name', function (SubscriptionPlan $item) {
            //     return generate_shortcode('subscription-plan');
            // });

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
               'trail',
               'trail_period',
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
            'trail' => [
                'title' => trans('plugins/subscription-plan::subscription-plan.trail'),
                'class' => 'text-start',
            ],
            'trail_period' => [
                'title' => trans('plugins/subscription-plan::subscription-plan.trail_period'),
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
        return $this->addCreateButton(route('subscription-plan.create'), 'subscription-plan.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('subscription-plan.deletes'), 'subscription-plan.destroy', parent::bulkActions());
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
