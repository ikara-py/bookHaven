<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;
use JonPurvis\Squeaky\Rules\Clean;

class StoreAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:authors,name', new Clean()],
            'description' => ['nullable', 'string', new Clean()],
            'country' => ['nullable', 'string', 'max:100', new Clean()],
            'date_of_birth' => ['nullable', 'date'],
            'date_of_death' => ['nullable', 'date', 'after:date_of_birth'],
        ];
    }
}
