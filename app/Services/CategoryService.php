<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function all()
    {
        return Category::orderBy('name')->get();
    }

    public function allExcept(int $categoryId)
    {
        return Category::where('id', '!=', $categoryId)->orderBy('name')->get();
    }

    public function listForAdmin()
    {
        return Category::withCount('books')->with('parent')->paginate(20);
    }

    public function listForBuyer()
    {
        return Category::withCount(['books' => function($query) {
            $query->where('status', 'active');
        }])->get();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): ?bool
    {
        return $category->delete();
    }
}
