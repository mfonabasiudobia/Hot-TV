<?php

namespace App\Http\Livewire\Admin\Gallery\Tables;

use App\Models\Gallery;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class Home extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

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

    public function datasource(): ?Builder
    {
        return Gallery::query();
    }

   
    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('image_formatted', function(Gallery $model) {
                $assetUrl = asset($model->file_path);
                return "<img src='$assetUrl' class='image-preview' />";
            })
            ->addColumn('created_at_formatted', function(Gallery $model) {
                return $model->createdAt();
            });
    }

    public function columns(): array
    {
        return [

            Column::add()
                ->title('Image')
                ->field('image_formatted'),

            Column::add()
                ->title('Created At')
                ->field('created_at_formatted')
                ->searchable()
        ];
    }


     public function filters(): array
     {
        return [
            Filter::datetimepicker('created_at'),
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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption("Edit")
               ->class('bg-indigo-500 action-btn')
               ->dispatch('trigger-edit-modal', [
                'id' => 'id', 
                'model' => Gallery::class,
                'title' => 'Are you sure?',
                'message' => 'Are you sure you want to delete this gallery?'
            ]),


           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-danger action-btn')
               ->dispatch('trigger-delete-modal', [
                'id' => 'id', 
                'model' => Gallery::class,
                'title' => 'Are you sure?',
                'message' => 'Are you sure you want to delete this gallery?'
            ]),
        ];
    }


}
