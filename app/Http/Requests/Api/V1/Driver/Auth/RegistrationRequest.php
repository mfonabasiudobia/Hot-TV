<?php

namespace App\Http\Requests\Api\V1\Driver\Auth;

use App\Enums\Api\V1\ApiResponseMessageEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
            'verification_docs' => 'required|array',
            'verification_docs.*' => 'file|mimes:jpeg,png,pdf|max:5120',
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
