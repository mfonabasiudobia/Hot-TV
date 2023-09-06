<?php

namespace Botble\Stream\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Stream\Supports\PostFormat;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Botble\Stream\Http\Rules\AvailableTime;

class StreamRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => ['required', new AvailableTime(request('schedule_date'))],
            'thumbnail' => 'required',
            'end_time' => 'required|after:start_time',
            'recorded_video' => 'required',
            'stream_type' => Rule::in(['recorded_video', 'podcast']),
        ];

        return $rules;
    }
}
