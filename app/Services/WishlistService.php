<?php
namespace App\Services;

use App\Models\Wishlist;

class WishlistService{
    public function get($userId){
        return Wishlist::with(['books.author', 'books.category'])->where('user_id', $userId)->firstOrFail();
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

    public function getBookIds(int $userId): array
    {
        $wishlist = Wishlist::where('user_id', $userId)->first();
        return $wishlist ? $wishlist->books()->pluck('books.id')->toArray() : [];
    }

    public function isInWishlist(int $userId, int $bookId): bool
    {
        $wishlist = Wishlist::where('user_id', $userId)->first();
        return $wishlist ? $wishlist->books()->where('book_id', $bookId)->exists() : false;
    }
}