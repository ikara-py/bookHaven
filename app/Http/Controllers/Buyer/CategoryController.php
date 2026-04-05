<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['books' => function($query) {
            $query->where('status', 'active');
        }])->get();

        return view('categories.index', compact('categories'));
    }
}
