<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartItemRequest;
use App\Services\CartService;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService){}

    public function index(Request $request){
        $cart =  $this->cartService->getCart($request->user()->id);
        $subtotal = $this->cartService->getSubtotal($request->user()->id);
        $discount = $this->cartService->getDiscount($request->user()->id, $subtotal);
        $total = $this->cartService->total($request->user()->id);
        
        return view('cart.index', compact('cart', 'subtotal', 'discount', 'total'));
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

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => ['required', 'string']]);
        
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->withErrors(['coupon_code' => 'This coupon is not currently available or has expired.'])->withInput();
        }

        if (!$coupon->is_active) {
            return back()->withErrors(['coupon_code' => 'This coupon is not currently available or has expired.'])->withInput();
        }

        $now = now();
        if (($coupon->starts_at && $coupon->starts_at > $now) || ($coupon->expires_at && $coupon->expires_at < $now)) {
            return back()->withErrors(['coupon_code' => 'This coupon is not currently available or has expired.'])->withInput();
        }

        if ($coupon->use_limit && $coupon->used_count >= $coupon->use_limit) {
            return back()->withErrors(['coupon_code' => 'This coupon is not currently available or has expired.'])->withInput();
        }

        $subtotal = $this->cartService->getSubtotal($request->user()->id);
        if ($subtotal < $coupon->min_order_amount) {
            return back()->withErrors(['coupon_code' => 'This coupon is not currently available or has expired.'])->withInput();
        }

        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'min_order_amount' => $coupon->min_order_amount
        ]]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
