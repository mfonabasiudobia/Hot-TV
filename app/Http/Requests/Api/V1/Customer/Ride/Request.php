<?php

namespace App\Http\Requests\Api\V1\Customer\Ride;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'street_name' => 'required',
            'duration' => 'required',
            'stream' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
