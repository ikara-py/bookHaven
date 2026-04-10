<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = $this->categoryService->listForBuyer();

        return view('categories.index', compact('categories'));
    }
}
