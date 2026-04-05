<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartItemRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService){}

    public function index(Request $request){
        $cart =  $this->cartService->getCart($request->user()->id);
        $total = $this->cartService->total($request->user()->id);
        return view('cart.index', compact('cart', 'total'));
    }

    public function addItem(CartItemRequest $request){
        $this->cartService->addItem($request->user()->id, $request->book_id, $request->quantity);
        return redirect()->route('cart.index')->with('success', 'Book added to cart.');
    }

    public function removeItem(Request $request, $itemId){
        $this->cartService->removeItem($request->user()->id, $itemId);
        
        if ($request->expectsJson()) {
            $total = $this->cartService->total($request->user()->id);
            return response()->json(['status' => 'success', 'total' => number_format($total, 2)]);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear(Request $request){
        $this->cartService->clear($request->user()->id);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'total' => '0.00']);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
