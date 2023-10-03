<?php

namespace Botble\Brand\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Brand\Models\Brand;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Botble\Table\DataTables;

class BrandTable extends TableAbstract
{
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, Brand $brand)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $brand;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (!Auth::user()->hasAnyPermission(['brand.edit', 'brand.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Brand $item) {
                if (!Auth::user()->hasPermission('brand.edit')) {
                    return BaseHelper::clean($item->name);
                }
                return Html::link(route('brand.edit', $item->getKey()), BaseHelper::clean($item->name));
            })
            ->editColumn('image', function (Brand $item) {
                return $this->displayThumbnail($item->image, ['width' => 70]);
            })
            ->editColumn('checkbox', function (Brand $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('created_at', function (Brand $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function (Brand $item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function (Brand $item) {
                return $this->getOperations('brand.edit', 'brand.destroy', $item);
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
               'image',
               'order',
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
            'image' => [
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'order' => [
                'title' => trans('core/base::tables.order'),
                'width' => '100px',
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
        return $this->addCreateButton(route('brand.create'), 'brand.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('brand.deletes'), 'brand.destroy', parent::bulkActions());
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
