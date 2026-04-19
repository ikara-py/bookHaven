<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;

class CartService{
    public function getCart($userId){
        return Cart::with('items.book')->where('user_id', $userId)->firstOrFail();
    }

    public function addItem($userId, $bookId, $quantity){
        $cart = Cart::where('user_id', $userId)->firstOrFail();
        $book = Book::findOrFail($bookId);
        if($book->stock < $quantity){
            throw new \Exception("Only {$book->stock} copies available.");
        }

        return CartItem::updateOrCreate(['cart_id' => $cart->id, 'book_id' => $bookId],
        ['quantity' => $quantity, 'price' => $book->price]);
    }


    public function removeItem($userId, $itemId){
        $cart = Cart::where('user_id', $userId)->firstOrFail();
        CartItem::where('id', $itemId)->where('cart_id', $cart->id)->delete();
    }


    public function clear($userId){
        Cart::where('user_id', $userId)->firstOrFail()->items()->delete();
    }

    public function total($userId){
        $subtotal = $this->getCart($userId)->items->sum(fn($i) => $i->price * $i->quantity);
        $discount = $this->getDiscount($userId, $subtotal);
        return max(0, $subtotal - $discount);
    }

    public function getSubtotal($userId){
        return $this->getCart($userId)->items->sum(fn($i) => $i->price * $i->quantity);
    }

    public function getDiscount($userId, $subtotal){
        $couponData = session('coupon');
        if(!$couponData) return 0;

        if($subtotal < $couponData['min_order_amount']){
            session()->forget('coupon');
            return 0;
        }

        if($couponData['type'] === 'percent'){
            return ($subtotal * $couponData['value']) / 100;
        }

        return min($subtotal, $couponData['value']);
    }
}