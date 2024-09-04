<?php

namespace App\Http\Requests\Api\V1\Customer\Ride;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'streat_name' => 'required',
            'ride_duration' => 'required',
            'type' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
