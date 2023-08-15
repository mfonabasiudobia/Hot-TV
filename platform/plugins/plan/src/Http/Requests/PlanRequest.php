<?php

namespace Botble\Plan\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Plan\Supports\PostFormat;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PlanRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_value' => 'required|numeric|min:0',
            'can_download' => 'required|in:0,1',
            'can_stream' => 'required|in:0,1',
            'discount_type' => Rule::in(['percent', 'fixed']),
        ];

        return $rules;
    }
}
