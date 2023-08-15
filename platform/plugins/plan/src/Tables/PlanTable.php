<?php

namespace Botble\Plan\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Plan\Exports\PlanExport;
use Botble\Plan\Models\Plan;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\DataTables;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PlanTable extends TableAbstract
{
    protected string $exportClass = PlanExport::class;

    protected int $defaultSortColumn = 6;

    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        Plan $plan
    ) {
        parent::__construct($table, $urlGenerator);

        $this->model = $plan;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (! Auth::user()->hasAnyPermission(['plan.edit', 'plan.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Plan $item) {
                if (! Auth::user()->hasPermission('plan.edit')) {
                    return BaseHelper::clean($item->name);
                }

                return Html::link(route('plan.edit', $item->getKey()), BaseHelper::clean($item->name));
            })
            ->editColumn('price', function (Plan $item) {
                return $item->price;
            })
            ->editColumn('checkbox', function (Plan $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('can_download', function (Plan $item) {
                return $item->can_download ? 'Yes' : 'No';
            })
            ->editColumn('can_stream', function (Plan $item) {
                return $item->can_download ? 'Yes' : 'No';
            })
            ->editColumn('created_at', function (Plan $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->addColumn('operations', function (Plan $item) {
                return $this->getOperations('plan.edit', 'plan.destroy', $item);
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
                'price',
                'can_download',
                'can_stream',
                'created_at',
                'updated_at'
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
            'price' => [
                'title' => trans('core/base::tables.price'),
                'class' => 'text-start',
            ],
            'can_download' => [
                'title' => trans('core/base::tables.can_download'),
                'class' => 'text-start',
            ],
            'can_stream' => [
                'title' => trans('core/base::tables.can_stream'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            // 'status' => [
            //     'title' => trans('core/base::tables.status'),
            //     'width' => '100px',
            //     'class' => 'text-center',
            // ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('plan.create'), 'plan.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('plan.deletes'), 'plan.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'price' => [
                'title' => trans('core/base::tables.price'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            // 'status' => [
            //     'title' => trans('core/base::tables.status'),
            //     'type' => 'customSelect',
            //     'choices' => BaseStatusEnum::labels(),
            //     'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            // ],
            // 'category' => [
            //     'title' => trans('plugins/Plan::plan.category'),
            //     'type' => 'select-search',
            //     'validate' => 'required|string',
            //     'callback' => 'getCategories',
            // ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
                'validate' => 'required|string|date',
            ],
        ];
    }

    public function applyFilterCondition(EloquentBuilder|QueryBuilder|EloquentRelation $query, string $key, string $operator, string|null $value): EloquentRelation|EloquentBuilder|QueryBuilder
    {
        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    public function saveBulkChangeItem(Model|Plan $item, string $inputKey, string|null $inputValue): Model|bool
    {
        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
