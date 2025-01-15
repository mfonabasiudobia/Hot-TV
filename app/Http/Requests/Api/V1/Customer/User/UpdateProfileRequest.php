<?php

namespace App\Http\Requests\Api\V1\Customer\User;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable',
            'avatar' => 'image|mimes:gif,jpg,jpeg,png|max:5120',
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
