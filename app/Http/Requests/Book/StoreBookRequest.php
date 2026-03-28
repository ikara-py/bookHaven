<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'origina_price' => 'nullable|numeric:min:0',
            'stock' =>'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'type' => 'required|in:physical,digital',
            'language' => 'nullable|string|max:10',
            'publication_year' =>'nullable|integer|min:1000|max:2099',
            'page_count' =>'nullable|integer|min:1',
            'cover' => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'pdf_path' => 'nullable|file|mimes:pdf|max:51200',
        ];
    }
}
