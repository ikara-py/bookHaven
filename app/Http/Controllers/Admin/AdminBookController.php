<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class AdminBookController extends Controller
{
    public function __construct(
        private BookService $bookService,
        private CategoryService $categoryService
    ){}

    public function index(Request $request){
        $query = Book::with('seller', 'category', 'author');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('isbn', 'like', "%{$term}%")
                  ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$term}%"));
            });
        }

        $books = $query->paginate(20)->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function edit(Book $book){
        $categories = $this->categoryService->all();
        $authors = Author::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories', 'authors'));
    }


    public function update(UpdateBookRequest $request, Book $book){
        $updated = $this->bookService->update($book, $request->validated());

        return back()->with('success', 'Book updated');
    }

    public function destroy(Book $book){
        $this->bookService->delete($book);
        return redirect()->route('admin.books.index')
                         ->with('success', 'Book removed. ');
    }
}
