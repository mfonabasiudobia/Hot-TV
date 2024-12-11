<?php

namespace App\Http\Requests\Api\V1\Driver\Ride;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'street_name' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'details' => 'required',
            'ride_type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => ApiResponseMessageEnum::VALIDATION_ERRORS->value,
            'data'      => $validator->errors()
        ], 422));
    }
}
