<?php

namespace Botble\Stream\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Stream\Exports\StreamExport;
use Botble\Stream\Models\Stream;
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

class StreamTable extends TableAbstract
{
    protected string $exportClass = StreamExport::class;

    protected int $defaultSortColumn = 6;

    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        Stream $stream
    ) {
        parent::__construct($table, $urlGenerator);

        $this->model = $stream;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (! Auth::user()->hasAnyPermission(['stream.edit', 'stream.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('title', function (Stream $item) {
                if (! Auth::user()->hasPermission('stream.edit')) {
                    return BaseHelper::clean($item->title);
                }

                return Html::link(route('stream.edit', $item->getKey()), BaseHelper::clean($item->title));
            })
            ->editColumn('schedule_date', function (Stream $item) {
                return BaseHelper::formatDate($item->schedule_date, "d M Y");
            })
            ->editColumn('start_time', function (Stream $item) {
                return BaseHelper::formatDate($item->start_time, "h: iA");
            })
             ->editColumn('end_time', function (Stream $item) {
                return BaseHelper::formatDate($item->end_time, "h: iA");
             })
             ->editColumn('stream_type', function (Stream $item) {
                return $item->stream_type;
             })
            ->editColumn('checkbox', function (Stream $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('created_at', function (Stream $item) {
                return BaseHelper::formatDate($item->created_at, "d M Y");
            })
            ->addColumn('operations', function (Stream $item) {
                return $this->getOperations('stream.edit', 'stream.destroy', $item);
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
                'title',
                'schedule_date',
                'start_time',
                'end_time',
                'stream_type',
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
            'title' => [
                'title' => trans('Title'),
                'class' => 'text-start',
            ],
            'schedule_date' => [
                'title' => trans('Schedule Date'),
                'class' => 'text-start',
            ],
            'start_time' => [
                'title' => trans('Start Time'),
                'class' => 'text-start',
            ],
            'end_time' => [
                'title' => trans('End Time'),
                'class' => 'text-start',
            ],
            'stream_type' => [
                'title' => trans('Stream Type'),
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
        return $this->addCreateButton(route('stream.create'), 'stream.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('stream.deletes'), 'stream.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'title' => [
                'title' => trans('Title'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'description' => [
                'title' => trans('description'),
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
            //     'title' => trans('plugins/Stream::stream.category'),
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

    public function saveBulkChangeItem(Model|Stream $item, string $inputKey, string|null $inputValue): Model|bool
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
