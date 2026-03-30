<?php
namespace App\Services;

use App\Models\Wishlist;

class WishlistService{
    public function get($userId){
        return Wishlist::with('books.authors')->where('user_id', $userId)->firstOrFail();
    }

    public function toggle($userId, $bookId){
        $wishlist = Wishlist::where('user_id', $userId)->firstOrFail();
        if($wishlist->books()->where('book_id', $bookId)->exists()){
            $wishlist->books()->detach($bookId);
            return 'removed';
        }

        $wishlist->books()->attach($bookId);
        return 'added';
    }
}