<?php
namespace App\Services;

use App\Models\Wishlist;

class WishlistService{
    public function get($userId){
        $wishlist = Wishlist::firstOrCreate(['user_id' => $userId]);
        $wishlist->load(['books.author', 'books.category']);
        return $wishlist;
    }

    public function toggle($userId, $bookId){
        $wishlist = Wishlist::firstOrCreate(['user_id' => $userId]);
        if($wishlist->books()->where('book_id', $bookId)->exists()){
            $wishlist->books()->detach($bookId);
            return 'removed';
        }

        $wishlist->books()->attach($bookId);
        return 'added';
    }

    public function getBookIds(int $userId): array
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => $userId]);
        return $wishlist ? $wishlist->books()->pluck('books.id')->toArray() : [];
    }

    public function isInWishlist(int $userId, int $bookId): bool
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => $userId]);
        return $wishlist ? $wishlist->books()->where('book_id', $bookId)->exists() : false;
    }
}