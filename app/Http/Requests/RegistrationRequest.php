<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:3' , 'max:30', 'regex:/^[a-zA-Z]+$/'],
            'last_name' => ['required', 'min:3' , 'max:30', 'regex:/^[a-zA-Z]+$/'],
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8|max:50'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
