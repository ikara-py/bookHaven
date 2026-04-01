<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartItemRequest;
use App\Services\CartService;
use COM;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService){}

    public function index(Request $request){
        $cart =  $this->cartService->getCart($request->user()->id);
        $total = $this->cartService->total($request->user()->id);
        return view('cart.index', compact('cart', 'total'));
        //dd($cart);
        //dd($total);
    }

    public function addItem(CartItemRequest $request){
        $this->cartService->addItem($request->user()->id, $request->book_id, $request->quantity);
        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function clear(Request $request){
        $this->cartService->clear($request->user()->id);
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
