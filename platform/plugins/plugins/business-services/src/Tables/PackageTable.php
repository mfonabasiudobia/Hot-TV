<?php

namespace Botble\BusinessService\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\BusinessService\Models\Package;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class PackageTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Package::class)
            ->addActions([
                EditAction::make()->route('business-services.packages.edit'),
                DeleteAction::make()->route('business-services.packages.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table->eloquent($this->query())
            ->editColumn('name', function (Package $package) {
                if (! $this->hasPermission('business-services.packages.edit')) {
                    return BaseHelper::clean($package->name);
                }

                return Html::link(route('business-services.packages.edit', $package->getKey()), BaseHelper::clean($package->name));
            })
            ->editColumn('duration', function (Package $package) {
                return $package->duration->label();
            })
            ->editColumn('is_popular', function (Package $package) {
                return Html::tag('span', $package->is_popular ? trans('core/base::base.yes') : trans('core/base::base.no'), [
                    'class' => sprintf('badge badge-%s', $package->is_popular ? 'success' : 'danger'),
                ]);
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
                    'price',
                    'duration',
                    'is_popular',
                    'created_at',
                    'status',
                ])
        );
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make(),
            Column::make('price')
                ->title(trans('plugins/business-services::business-services.price'))
                ->width(100),
            Column::make('duration')
                ->title(trans('plugins/business-services::business-services.duration'))
                ->width(100),
            Column::make('is_popular')
                ->title(trans('plugins/business-services::business-services.is_popular'))
                ->width(100),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('business-services.packages.create'), 'business-services.packages.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('business-services.packages.destroy'),
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
