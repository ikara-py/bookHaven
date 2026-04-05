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
        $wishlistBookIds = auth()->check() && auth()->user()->wishlist 
            ? auth()->user()->wishlist->books()->pluck('books.id')->toArray() 
            : [];
        return view('books.index', compact('books', 'wishlistBookIds'));
    }

    public function show(Book $book){
        $book = $this->bookService->show($book);
        $isInWishlist = auth()->check() && auth()->user()->wishlist 
            ? auth()->user()->wishlist->books()->where('book_id', $book->id)->exists() 
            : false;
        return view('books.show', compact('book', 'isInWishlist'));
    }

    
}
