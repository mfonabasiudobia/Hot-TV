<?php

namespace App\Http\Livewire\Admin\Shoutout\Tables;


use App\Models\Shoutout;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class Home extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public function setUp(): array
    {
        $this->showCheckBox();
        return [
            Exportable::make('export')->striped()->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

   public function datasource(): Builder
    {
        return Shoutout::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('created_at_formatted', function(Shoutout $model){
                return $model->createdAt();
            })
            ->addColumn('status_formatted', function(Shoutout $model){
                return $model->status == 'published' ? "<span class='px-3 py-1 rounded-full bg-green-800'>Published</span>" : "<span
                    class='px-3 py rounded-full bg-red-200'>Unpublished</span>";
            });
    }

    public function columns(): array
    {
        return [
            Column::make('SNO', '')->index(),
            Column::make('Title', 'title')
                ->searchable()
                ->sortable(),
            Column::make('Status', 'status_formatted'),
            Column::make('Created At', 'created_at_formatted'),
        ];
    }

    public function onUpdatedEditable($id, $field, $value): void{
        Shoutout::query()->find($id)->update([
            $field => $value,
        ]);
    }

    public function filters(): array
    {
        return [
            Filter::inputText('title'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    public function actions(): array
    {
       return [
           Button::add('edit')
                ->caption("<i class='las la-pencil-alt'></i>")
                ->class('bg-gray-600 cursor-pointer text-white px-3 py-1 m-1 rounded text-sm')
                ->target('_self')
                ->route('admin.shoutout.edit', ['id' => 'id']),
           Button::add('destroy')
                ->caption("<i class='las la-trash'></i>")
                ->class('bg-red-500 cursor-pointer text-white px-3 py-1 m-1 rounded text-sm')
                ->dispatch('trigger-delete-modal', [
                    'id' => 'id',
                    'model' => Shoutout::class,
                    'title' => 'Are you sure?',
                    'message' => 'Are you sure you want to delete this category?'
                ])
       ];
    }

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($Podcast) => $Podcast->id === 1)
                ->hide(),
        ];
    }
    */
}
