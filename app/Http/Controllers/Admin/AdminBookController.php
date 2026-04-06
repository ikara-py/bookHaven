<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class AdminBookController extends Controller
{
    public function __construct(private BookService $bookService){}

    public function index(){
        $books = Book::with('seller', 'category', 'author')
                    ->paginate(20);

        return view('admin.books.index', compact('books'));
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
