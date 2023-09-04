<?php

namespace Botble\BusinessService\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\BusinessService\Models\ServiceCategory;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class ServiceCategoryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ServiceCategory::class)
            ->addActions([
                EditAction::make()->route('business-services.service-categories.edit'),
                DeleteAction::make()->route('business-services.service-categories.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table->eloquent($this->query())
            ->editColumn('name', function (ServiceCategory $category) {
                if (! $this->hasPermission('business-services.service-categories.edit')) {
                    return BaseHelper::clean($category->name);
                }

                return Html::link(route('business-services.service-categories.edit', $category->getKey()), BaseHelper::clean($category->name));
            });

        return $this->toJson($data);
    }

    public function query(): Builder
    {
        return $this->applyScopes(
            $this->getModel()
                ->query()
                ->select([
                    'id',
                    'name',
                    'status',
                    'created_at',
                ])
        );
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make(),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('business-services.service-categories.create'), 'business-services.service-categories.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('business-services.service-categories.destroy'),
        ];
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
