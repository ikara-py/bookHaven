<?php

namespace App\Http\Requests\Auth;

use JonPurvis\Squeaky\Rules\Clean;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:100', new Clean()],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:buyer,seller,buyer_seller'],
            'gender' => ['required', 'in:male,female'],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:500', new Clean()],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'bio' => ['nullable', 'string', 'max:1000', new Clean()],
            'store_name' => ['required_if:role,seller', 'required_if:role,buyer_seller', 'nullable', 'string', 'max:100', new Clean()]
        ];
    }
}
