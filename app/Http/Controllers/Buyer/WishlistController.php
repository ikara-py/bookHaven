<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WishlistService;

class WishlistController extends Controller
{
    public function __construct(private WishlistService $wishlistService){}

    public function index(Request $request){
        $wishlist = $this->wishlistService->get($request->user()->id);
        return view('wishlist.index', compact('wishlist'));
    }

    public function toggle(Request $request){
        $request->validate(['book_id' => ['required', 'exists:books,id']]);
        $result = $this->wishlistService->toggle($request->user()->id, $request->book_id);
        
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'action' => $result]);
        }
        
        return back()->with('success', "Book {$result} from wishlist");
    }
}
