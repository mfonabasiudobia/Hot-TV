<?php

namespace Botble\Tvshow\Http\Controllers;

use Botble\Tvshow\Http\Requests\TvshowRequest;
use Botble\Tvshow\Models\Tvshow;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Tvshow\Tables\TvshowTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Tvshow\Forms\TvshowForm;
use Botble\Base\Forms\FormBuilder;

class TvshowController extends BaseController
{
    public function index(TvshowTable $table)
    {
        PageTitle::setTitle(trans('plugins/tvshow::tvshow.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/tvshow::tvshow.create'));

        return $formBuilder->create(TvshowForm::class)->renderForm();
    }

    public function store(TvshowRequest $request, BaseHttpResponse $response)
    {
        $tvshow = Tvshow::query()->create($request->input());

        event(new CreatedContentEvent(TVSHOW_MODULE_SCREEN_NAME, $request, $tvshow));

        return $response
            ->setPreviousUrl(route('tvshow.index'))
            ->setNextUrl(route('tvshow.edit', $tvshow->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Tvshow $tvshow, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $tvshow->name]));

        return $formBuilder->create(TvshowForm::class, ['model' => $tvshow])->renderForm();
    }

    public function update(Tvshow $tvshow, TvshowRequest $request, BaseHttpResponse $response)
    {
        $tvshow->fill($request->input());

        $tvshow->save();

        event(new UpdatedContentEvent(TVSHOW_MODULE_SCREEN_NAME, $request, $tvshow));

        return $response
            ->setPreviousUrl(route('tvshow.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Tvshow $tvshow, Request $request, BaseHttpResponse $response)
    {
        try {
            $tvshow->delete();

            event(new DeletedContentEvent(TVSHOW_MODULE_SCREEN_NAME, $request, $tvshow));

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
            $tvshow = Tvshow::query()->findOrFail($id);
            $tvshow->delete();
            event(new DeletedContentEvent(TVSHOW_MODULE_SCREEN_NAME, $request, $tvshow));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
