<?php

namespace App\Http\Requests\Api\V1\Customer\Ecommerce\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
            'address' => 'required',
            'country' => 'required',
            'post_code' => 'required',
            'city' => 'required',
            'email' => 'required',
            'payment_method' => 'required',
            'save_shipping' => 'required|bool'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
