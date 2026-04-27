<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function all()
    {
        return Author::orderBy('name')->get();
    }

    public function listForAdmin()
    {
        return Author::withCount('books')->orderBy('name')->paginate(20);
    }

    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function update(Author $author, array $data): bool
    {
        return $author->update($data);
    }

    public function delete(Author $author): ?bool
    {
        return $author->delete();
    }
}
