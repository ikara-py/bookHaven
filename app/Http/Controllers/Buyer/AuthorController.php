<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount(['books' => function($query) {
            $query->where('status', 'active');
        }])->get();

        return view('authors.index', compact('authors'));
    }
}
