<?php

namespace App\Http\Requests\Book;

use JonPurvis\Squeaky\Rules\Clean;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'author_id' => ['required_without:new_author_name', 'nullable', 'exists:authors,id'],
            'new_author_name' => ['nullable', 'string', 'max:255', new Clean()],
            'type' => ['required', 'in:physical,digital'],
            'language' => ['nullable', 'string', 'max:10'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:2099'],
            'page_count' => ['nullable', 'integer', 'min:1'],
            'cover' => ['nullable', 'image', 'mimes:jpg,png,webp', 'max:2048'],
            'ebook_file' => ['required_if:type,digital', 'nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }
}
