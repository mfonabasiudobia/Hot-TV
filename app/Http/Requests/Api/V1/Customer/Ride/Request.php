<?php

namespace App\Http\Requests\Api\V1\Customer\Ride;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'ride_id' => 'required|exists:rides,id',
            'payment_method' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
