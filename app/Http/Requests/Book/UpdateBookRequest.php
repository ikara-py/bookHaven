<?php

namespace App\Http\Requests\Book;

use JonPurvis\Squeaky\Rules\Clean;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255', new Clean()],
            'isbn' => ['sometimes', 'nullable', 'string', 'unique:books,isbn,' . ($this->book->id ?? $this->book)],
            'description' => ['sometimes', 'nullable', 'string', new Clean()],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'original_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'author_id' => ['required_without:new_author_name', 'nullable', 'sometimes', 'exists:authors,id'],
            'new_author_name' => ['sometimes', 'nullable', 'string', 'max:255', new Clean()],
            'type' => ['sometimes', 'in:physical,digital'],
            'language' => ['sometimes', 'nullable', 'string', 'max:10'],
            'publication_year' => ['sometimes', 'nullable', 'integer', 'min:1000', 'max:2099'],
            'page_count' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'cover' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,webp', 'max:2048'],
            'ebook_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'status' => ['sometimes', 'in:active,inactive']
        ];
    }
}
