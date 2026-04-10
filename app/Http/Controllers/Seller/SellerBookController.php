<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class SellerBookController extends Controller
{
    public function __construct(
        private BookService $bookService,
        private CategoryService $categoryService
    ){}

    public function index(Request $request){
        $books = Book::where('seller_id', $request->user()->id)
                    ->with('category', 'author')
                    ->paginate(20);
        return view('seller.books.index', compact('books'));
    }

    public function create() {
        $authors = Author::all();
        $categories = $this->categoryService->all();
        return view('seller.books.create', compact('authors', 'categories'));
    }


    public function store(StoreBookRequest $request){
        $book = $this->bookService->create($request->validated(), $request->user()->id);

        return redirect()->route('seller.books.index')
                         ->with('success', 'Book listed successfully');
    }
    
    public function edit(Request $request, Book $book){
        if($book->seller_id !== $request->user()->id){
            abort(403);
        }

        $authors = Author::all();
        $categories = $this->categoryService->all();

        return view('seller.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book ){
        if($book->seller_id !== $request->user()->id){
            abort(403);
        };

        $updated = $this->bookService->update($book, $request->validated());
        return redirect()->route('seller.books.index')
                         ->with('success', 'Book updated');
    }


    public function destroy(Request $request, Book $book){
        if($book->seller_id !== $request->user()->id){
            abort(403);
        };

        $this->bookService->delete($book);
        return redirect()->route('seller.books.index')
                         ->with('success', 'The book deleted successfully');
    }
}
