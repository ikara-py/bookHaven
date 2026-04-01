<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private BookService $bookService){}

    public function index(Request $request){
        $books = $this->bookService->listPublic($request->only(['search', 'category_id', 'type']));
        //dd($books);
        return view('books.index', compact('books'));
    }

    public function show(Book $book){
        $book = $this->bookService->show($book);
        //dd($book);
        return view('book.show', compact('book'));
    }

    
}
