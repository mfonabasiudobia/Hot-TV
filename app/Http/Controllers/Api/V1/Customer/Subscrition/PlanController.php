<?php

namespace App\Http\Controllers\Api\V1\Customer\Subscrition;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Customer\Subscription\PlanResource;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;

class PlanController extends Controller
{
    public function __invoke()
    {
        $plans = SubscriptionPlan::where('status', BaseStatusEnum::PUBLISHED())->get();

        return response()->json([
            'success' => true,
            'message' => ApiResponseMessageEnum::SUBSCRIPTION_PLANS->value,
            'data' => PlanResource::collection($plans)
        ]);

    }
}
