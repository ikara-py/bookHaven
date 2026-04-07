<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;

class BookService{
    public function listPublic($filters){
        $query = Book::with(['author','category','seller'])
                    ->where('status', 'active');

        if(!empty($filters['search'])){
            $term = $filters['search'];
            $query->where(function($q) use ($term){
                $q->where('title', 'like', "%{$term}%")
                  ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$term}%"));
            });
        }

        if(!empty($filters['category_id'])){
            $query->where('category_id', $filters['category_id']);
        }

        if(!empty($filters['type'])){
            $query->where('type', $filters['type']);
        }

        return $query->latest()->paginate(20);
    }


    public function show(Book $book){
        $book->increment('views');
        return $book->load(['author', 'category', 'seller.SellerProfile']);
    }

    public function create($data, $sellerId){
        if(!empty($data['new_author_name'])){
            $author = Author::create(['name' => $data['new_author_name']]);
            $data['author_id'] = $author->id;
        }

        if(isset($data['cover']) && $data['cover'] instanceof \Illuminate\Http\UploadedFile){
            $data['cover'] = $data['cover']->store('books/covers', 'public');   
        }
        return Book::create(array_merge($data, ['seller_id' => $sellerId]));
    }


    public function update(Book $book, array $data): Book
    {
        if(!empty($data['new_author_name'])){
            $author = Author::create(['name' => $data['new_author_name']]);
            $data['author_id'] = $author->id;
        }

        if (isset($data['cover']) && $data['cover'] instanceof \Illuminate\Http\UploadedFile) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $data['cover'] = $data['cover']->store('books/covers', 'public');
        }
        $book->update($data);
        return $book->fresh();
    }

    public function delete(Book $book): void
    {
        if ($book->cover) Storage::disk('public')->delete($book->cover);
        $book->delete();
    }
    

}