<?php

namespace Botble\SubscriptionPlan\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SubscritionsRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:220',
            'status' => Rule::in(BaseStatusEnum::values()),
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'price' => 'required'
        ];
    }
}
