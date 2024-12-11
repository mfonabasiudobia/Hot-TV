<?php

namespace Botble\SubscriptionPlan\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Models\Subscription;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Botble\Table\DataTables;

class SubscritionsTable extends TableAbstract
{
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, Subscription $subscription)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $subscription;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (!Auth::user()->hasAnyPermission(['subscriptions.edit', 'subscriptions.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Subscription $item) {
                if (!Auth::user()->hasPermission('subscriptions.edit')) {
                    return BaseHelper::clean($item->name);
                }
                return Html::link(route('subscriptions.edit', $item->getKey()), BaseHelper::clean($item->name));
            })
            ->editColumn('checkbox', function (Subscription $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('created_at', function (Subscription $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function (Subscription $item) {
                return $item->status->toHtml();
            })
            ->editColumn('subscription_plan_id', function (Subscription $item) {
                return $item->plan->name;
            })
            ->editColumn('stripe_plan_id', function (Subscription $item) {
                return $item->stripe_plan_id;
            })
            ->editColumn('paypal_plan_id', function (Subscription $item) {
                return $item->paypal_plan_id;
            })
            ->editColumn('price', function (Subscription $item) {
                return $item->price;
            })
            ->addColumn('operations', function (Subscription $item) {
                return $this->getOperations('subscriptions.edit', 'subscriptions.destroy', $item);
            });
            
            //if (function_exists('shortcode')) {
                // $data = $data->editColumn('alias', function (Subscription $item) {
                //     return generate_shortcode('subscription-plan');
                // });
            //}

            

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
               'subscription_plan_id',
               'price',
               'stripe_plan_id',
               'paypal_plan_id',
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
            'subscription_plan_id' => [
                'title' => trans('plugins/subscription-plan::subscriptions.plan'),
                'class' => 'text-start'
            ],
            'price' => [
                'title' => trans('plugins/subscription-plan::subscriptions.price'),
                'class' => 'text-start'
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
        return $this->addCreateButton(route('subscriptions.create'), 'subscriptions.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('subscriptions.deletes'), 'subscriptions.destroy', parent::bulkActions());
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
