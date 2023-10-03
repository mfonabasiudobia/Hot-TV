<?php

namespace Botble\Brand\Http\Controllers;

use Botble\Brand\Http\Requests\BrandRequest;
use Botble\Brand\Models\Brand;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Brand\Tables\BrandTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Brand\Forms\BrandForm;
use Botble\Base\Forms\FormBuilder;

class BrandController extends BaseController
{
    public function index(BrandTable $table)
    {
        PageTitle::setTitle(trans('plugins/brand::brand.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/brand::brand.create'));

        return $formBuilder->create(BrandForm::class)->renderForm();
    }

    public function store(BrandRequest $request, BaseHttpResponse $response)
    {
        $brand = Brand::query()->create($request->input());

        event(new CreatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));

        return $response
            ->setPreviousUrl(route('brand.index'))
            ->setNextUrl(route('brand.edit', $brand->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Brand $brand, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $brand->name]));

        return $formBuilder->create(BrandForm::class, ['model' => $brand])->renderForm();
    }

    public function update(Brand $brand, BrandRequest $request, BaseHttpResponse $response)
    {
        $brand->fill($request->input());

        $brand->save();

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));

        return $response
            ->setPreviousUrl(route('brand.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Brand $brand, Request $request, BaseHttpResponse $response)
    {
        try {
            $brand->delete();

            event(new DeletedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));

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
            $brand = Brand::query()->findOrFail($id);
            $brand->delete();
            event(new DeletedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $brand));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
