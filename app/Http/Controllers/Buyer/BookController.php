<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\BookService;
use App\Services\CategoryService;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        private BookService $bookService,
        private CategoryService $categoryService,
        private WishlistService $wishlistService
    ){}

    public function index(Request $request){
        $books = $this->bookService->listPublic($request->only(['search', 'category_id', 'type']));
        $categories = $this->categoryService->all();
        $topBooks = $this->bookService->getTopBooks(10);
        
        $wishlistBookIds = auth()->check() 
            ? $this->wishlistService->getBookIds(auth()->id()) 
            : [];
            
        return view('books.index', compact('books', 'wishlistBookIds', 'categories', 'topBooks'));
    }

    public function show(Book $book){
        $book = $this->bookService->show($book);
        $isInWishlist = auth()->check() 
            ? $this->wishlistService->isInWishlist(auth()->id(), $book->id) 
            : false;
            
        return view('books.show', compact('book', 'isInWishlist'));
    }

    
}
