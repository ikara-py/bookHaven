<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use JonPurvis\Squeaky\Rules\Clean;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = $this->categoryService->listForAdmin();
        $allCategories = $this->categoryService->all();
        
        return view('admin.categories.index', compact('categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name', new Clean()],
            'description' => ['nullable', 'string', new Clean()],
            'parent_id' => ['nullable', 'exists:categories,id'],
        ]);

        $this->categoryService->create($validated);

        return back()->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $allCategories = $this->categoryService->allExcept($category->id);
        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id, new Clean()],
            'description' => ['nullable', 'string', new Clean()],
            'parent_id' => ['nullable', 'exists:categories,id', 'not_in:' . $category->id],
        ]);

        $this->categoryService->update($category, $validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);

        return back()->with('success', 'Category deleted successfully. Books in this category are now uncategorized.');
    }
}
