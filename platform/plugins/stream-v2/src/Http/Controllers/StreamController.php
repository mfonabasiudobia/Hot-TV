<?php

namespace Botble\Stream\Http\Controllers;

use Botble\ACL\Models\User;
use Botble\Base\Events\BeforeUpdateContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Stream\Forms\StreamForm;
use Botble\Stream\Http\Requests\StreamRequest;
use Botble\Stream\Models\Stream;
use Botble\Stream\Repositories\Interfaces\StreamInterface;
use Botble\Stream\Tables\StreamTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreamController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(
        protected StreamInterface $streamRepository
    ) {
    }

    public function index(StreamTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/stream::stream.menu_name'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/Stream::stream.create'));

        return $formBuilder->create(StreamForm::class)->renderForm();
    }

    public function store(
        StreamRequest $request,
        BaseHttpResponse $response
    ) {
        /**
         * @var Stream $stream
         */

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

        $request->request->remove('seo_meta');

        return $response
            ->setPreviousUrl(route('stream.index'))
            ->setNextUrl(route('stream.edit', $stream->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(FormBuilder $formBuilder, $id)
    {

        // $streamRanges = \App\Repositories\StreamRepository::getTimeRangeAlreadyScheduled('2023-08-17');

        // dd($streamRanges);

        // dd(\App\Repositories\StreamRepository::isTimeInRange("00:00:00", $streamRanges));

        $stream = Stream::find($id);

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $stream->name]));
        
        return $formBuilder->create(StreamForm::class, ['model' => $stream])->renderForm();
    }

    public function update(
        $id,
        StreamRequest $request,
        BaseHttpResponse $response
    ) {
        // event(new BeforeUpdateContentEvent($request, $stream));

        // $stream->fill($request->input());

        $stream = Stream::find($id);

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

        $this->streamRepository->update(['id' => $stream->id], $data);

        // event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $stream));

        // $tagService->execute($request, $stream);

        // $categoryService->execute($request, $stream);

        return $response
            ->setPreviousUrl(route('stream.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $stream = Stream::find($id);

            $this->streamRepository->delete($stream);

            // event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $stream));

            return $response
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, new Stream(), POST_MODULE_SCREEN_NAME);
    }

    public function getWidgetRecentStreams(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->integer('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;

        $stream = $this->streamRepository->advancedGet([
            'with' => ['slugable'],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => [
                'per_page' => $limit,
                'current_paged' => $request->integer('page', 1),
            ],
        ]);

        return $response
            ->setData(view('plugins/Stream::stream.widgets.stream', compact('stream', 'limit'))->render());
    }
}
