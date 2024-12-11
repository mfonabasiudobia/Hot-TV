<?php

namespace App\Http\Requests\Api\V1\Customer\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email'
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
