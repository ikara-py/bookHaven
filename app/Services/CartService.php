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
        return $this->getCart($userId)->items->sum(fn($i) => $i->price * $i->quantity);
    }
}