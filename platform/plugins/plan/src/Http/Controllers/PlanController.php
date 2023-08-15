<?php

namespace Botble\Plan\Http\Controllers;

use Botble\ACL\Models\User;
use Botble\Base\Events\BeforeUpdateContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Plan\Forms\PlanForm;
use Botble\Plan\Http\Requests\PlanRequest;
use Botble\Plan\Models\Plan;
use Botble\Plan\Repositories\Interfaces\PlanInterface;
use Botble\Plan\Tables\PlanTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(
        protected PlanInterface $planRepository
    ) {
    }

    public function index(PlanTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/plan::plan.menu_name'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/Plan::plan.create'));

        return $formBuilder->create(PlanForm::class)->renderForm();
    }

    public function store(
        PlanRequest $request,
        BaseHttpResponse $response
    ) {
        /**
         * @var Plan $plan
         */

        //  dd($request->all());

         $data = [
            'name' => $request->name,
            'price' => $request->price,
            'discount_value' => $request->discount_value,
            'can_download' => $request->can_download,
            'can_stream' => $request->can_stream,
            'discount_type' => $request->discount_type
         ];

        $plan = $this->planRepository->createOrUpdate($data);

        $request->request->remove('seo_meta');

        return $response
            ->setPreviousUrl(route('plan.index'))
            ->setNextUrl(route('plan.edit', $plan->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(FormBuilder $formBuilder, $id)
    {

        $plan = Plan::find($id);

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $plan->name]));
        
        return $formBuilder->create(PlanForm::class, ['model' => $plan])->renderForm();
    }

    public function update(
        $id,
        PlanRequest $request,
        BaseHttpResponse $response
    ) {
        // event(new BeforeUpdateContentEvent($request, $plan));

        // $plan->fill($request->input());

        $plan = Plan::find($id);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'discount_value' => $request->discount_value,
            'can_download' => $request->can_download,
            'can_stream' => $request->can_stream,
            'discount_type' => $request->discount_type
        ];

        $this->planRepository->update(['id' => $plan->id], $data);

        // event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $plan));

        // $tagService->execute($request, $plan);

        // $categoryService->execute($request, $plan);

        return $response
            ->setPreviousUrl(route('plan.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $plan = Plan::find($id);

            $this->planRepository->delete($plan);

            // event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $plan));

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
        return $this->executeDeleteItems($request, $response, new Plan(), POST_MODULE_SCREEN_NAME);
    }

    public function getWidgetRecentPlans(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->integer('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;

        $plan = $this->planRepository->advancedGet([
            'with' => ['slugable'],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => [
                'per_page' => $limit,
                'current_paged' => $request->integer('page', 1),
            ],
        ]);

        return $response
            ->setData(view('plugins/Plan::plan.widgets.plan', compact('plan', 'limit'))->render());
    }
}
