<?php

namespace Botble\Stream\Http\Controllers;

use Botble\Stream\Http\Requests\StreamRequest;
use Botble\Stream\Models\Stream;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Stream\Tables\StreamTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Stream\Forms\StreamForm;
use Botble\Base\Forms\FormBuilder;

class StreamController extends BaseController
{
    public function index(StreamTable $table)
    {
        PageTitle::setTitle(trans('plugins/stream::stream.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/stream::stream.create'));

        return $formBuilder->create(StreamForm::class)->renderForm();
    }

    public function store(StreamRequest $request, BaseHttpResponse $response)
    {
        $stream = Stream::query()->create($request->input());

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'recorded_video' => $request->recorded_video,
            'thumbnail' => $request->thumbnail,
            'stream_type' => $request->stream_type
        ];

        $stream = $this->streamRepository->createOrUpdate($data);

        // event(new CreatedContentEvent(STREAM_MODULE_SCREEN_NAME, $request, $stream));

        return $response
            ->setPreviousUrl(route('stream.index'))
            ->setNextUrl(route('stream.edit', $stream->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Stream $stream, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $stream->name]));

        return $formBuilder->create(StreamForm::class, ['model' => $stream])->renderForm();
    }

    public function update(Stream $stream, StreamRequest $request, BaseHttpResponse $response)
    {
        $stream->fill($request->input());

        $stream->save();

        event(new UpdatedContentEvent(STREAM_MODULE_SCREEN_NAME, $request, $stream));

        return $response
            ->setPreviousUrl(route('stream.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Stream $stream, Request $request, BaseHttpResponse $response)
    {
        try {
            $stream->delete();

            event(new DeletedContentEvent(STREAM_MODULE_SCREEN_NAME, $request, $stream));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $stream = Stream::query()->findOrFail($id);
            $stream->delete();
            event(new DeletedContentEvent(STREAM_MODULE_SCREEN_NAME, $request, $stream));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
