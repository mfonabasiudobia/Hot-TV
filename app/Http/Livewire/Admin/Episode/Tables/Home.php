<?php

namespace App\Http\Livewire\Admin\Episode\Tables;

use App\Models\Episode;
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

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */

    public $tvshow;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Episode>
     */
    public function datasource(): Builder
    {
        return Episode::query()
        ->when($this->tvshow, function($q){
            $q->where('tv_show_id', $this->tvshow->id);
        });
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('created_at_formatted', function(Episode $model){
                return $model->createdAt();
            })
            ->addColumn('status_formatted', function(Episode $model){
                return $model->status == 'published' ? "<span class='px-3 py-1 rounded-full bg-green-800'>Published</span>" : "<span
                    class='px-3 py rounded-full bg-red-200'>Unpublished</span>";
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('SNO', '')->index(),

            Column::make('Title', 'title')
                ->searchable()
                ->sortable(),

            Column::make('Season', 'season_number')
                ->searchable()
                ->sortable(),

            Column::make('Episode', 'episode_number')
                ->searchable()
                ->sortable(),
            
            Column::make('Status', 'status_formatted'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('title'),
            Filter::inputText('season_number'),
            Filter::inputText('episode_number'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Episode Action Buttons.
     *
     * @return array<int, Button>
     */
    


    public function actions(): array
    {
       return [

           Button::add('edit')
                ->caption("<i class='las la-pencil-alt'></i>")
                ->class('bg-gray-600 cursor-pointer text-white px-3 py-1 m-1 rounded text-sm')
                ->target('_self')
                ->route('admin.tv-show.episode.edit', [ 'id' => 'id' ]),

           Button::add('destroy')
                ->caption("<i class='las la-trash'></i>")
                ->class('bg-red-500 cursor-pointer text-white px-3 py-1 m-1 rounded text-sm')
                ->dispatch('trigger-delete-modal', [
                    'id' => 'id',
                    'model' => Episode::class,
                    'title' => 'Are you sure?',
                    'message' => 'Are you sure you want to delete this episode?'
                ])
        ];
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Episode Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($Episode) => $Episode->id === 1)
                ->hide(),
        ];
    }
    */
}
