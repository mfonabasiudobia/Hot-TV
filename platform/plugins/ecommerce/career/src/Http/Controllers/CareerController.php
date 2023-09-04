<?php

namespace ArchiElite\Career\Http\Controllers;

use ArchiElite\Career\Forms\CareerForm;
use ArchiElite\Career\Http\Requests\CareerRequest;
use ArchiElite\Career\Models\Career;
use ArchiElite\Career\Tables\CareerTable;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CareerController extends BaseController
{
    public function __construct(protected BaseHttpResponse $response)
    {
    }

    public function index(CareerTable $table): View|JsonResponse
    {
        PageTitle::setTitle(trans('plugins/career::career.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder): string
    {
        PageTitle::setTitle(trans('plugins/career::career.create'));

        return $formBuilder->create(CareerForm::class)->renderForm();
    }

    public function store(CareerRequest $request): BaseHttpResponse
    {
        $career = Career::query()->create($request->validated());

        event(new CreatedContentEvent('career', $request, $career));

        return $this->response
            ->setPreviousUrl(route('careers.index'))
            ->setNextUrl(route('careers.edit', $career->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Career $career, FormBuilder $formBuilder, Request $request): string
    {
        event(new BeforeEditContentEvent($request, $career));

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $career->name]));

        return $formBuilder->create(CareerForm::class, ['model' => $career])->renderForm();
    }

    public function update(Career $career, CareerRequest $request): BaseHttpResponse
    {
        $career->update($request->validated());

        event(new UpdatedContentEvent('career', $request, $career));

        return $this->response
            ->setPreviousUrl(route('careers.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Career $career, Request $request): BaseHttpResponse
    {
        try {
            $career->delete();

            event(new DeletedContentEvent('career', $request, $career));

            return $this->response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $this->response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
