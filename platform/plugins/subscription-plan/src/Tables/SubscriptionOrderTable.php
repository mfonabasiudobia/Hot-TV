<?php

namespace Botble\SubscriptionPlan\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionOrder;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Botble\Table\DataTables;

class SubscriptionOrderTable extends TableAbstract
{
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, SubscriptionOrder $subscriptionOrder)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $subscriptionOrder;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (!Auth::user()->hasAnyPermission(['subscription-order.edit', 'subscription-order.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('user_id', function (SubscriptionOrder $item) {
                return $item->user->email;
            })
            ->editColumn('subscription_id', function (SubscriptionOrder $item) {
                return $item->subscription->name;
            })
            ->editColumn('amount', function (SubscriptionOrder $item) {
                return $item->amount;
            })
            ->editColumn('tax', function (SubscriptionOrder $item) {
                return $item->tax_amount;
            })
            ->editColumn('sub_tatal', function (SubscriptionOrder $item) {
                return $item->sub_total;
            })
            ->editColumn('checkbox', function (SubscriptionOrder $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('created_at', function (SubscriptionOrder $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            
            ->addColumn('operations', function (SubscriptionOrder $item) {
                return $this->getOperations('subscription-order.edit', 'subscription-order.destroy', $item);
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
               'user_id',
               'subscription_id',
               'tax_amount',
               'sub_total',
               'created_at',
               
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
            'user_id' => [
                'title' => trans('plugins/subscription-plan::subscription-order.name'),
                'class' => 'text-start',
            ],
            'subscription_id' => [
                'title' => trans('plugins/subscription-plan::subscription-order.plan'),
                'class' => 'text-start',
            ],
            'amount' => [
                'title' => trans('plugins/subscription-plan::subscription-order.amount'),
                'class' => 'text-start',
            ],
            'tax_amount' => [
                'title' => trans('plugins/subscription-plan::subscription-order.tax'),
                'class' => 'text-start',
            ],
            'sub_tatal' => [
                'title' => trans('plugins/subscription-plan::subscription-order.sub_total'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('subscription-order.create'), 'subscription-order.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('subscription-order.deletes'), 'subscription-order.destroy', parent::bulkActions());
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
