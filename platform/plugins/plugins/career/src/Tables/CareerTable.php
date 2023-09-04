<?php

namespace ArchiElite\Career\Tables;

use ArchiElite\Career\Models\Career;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\Html;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class CareerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Career::class)
            ->addActions([
                EditAction::make()->route('careers.edit'),
                DeleteAction::make()->route('careers.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->alignLeft(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('careers.destroy'),
            ])
            ->addBulkChanges([
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
                    'type' => 'datePicker',
                ],
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'created_at',
                    'status',
                ]);
            })
            ->onAjax(fn (): JsonResponse => $this->toJson(
                $this->table
                    ->eloquent($this->query())
                    ->editColumn('name', function (Career $item) {
                        if (! $this->hasPermission('careers.edit')) {
                            return $item->name;
                        }

                        return Html::link(route('careers.edit', $item->id), $item->name);
                    })
            ));
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('careers.create'), 'careers.create');
    }
}
