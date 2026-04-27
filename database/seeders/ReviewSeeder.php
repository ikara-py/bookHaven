<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();
        $users = User::whereIn('role', ['buyer', 'buyer_seller'])->get();

        if ($books->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($books as $book) {
            $reviewCount = rand(1, min(4, $users->count()));
            $reviewers = $users->random($reviewCount);
            
            foreach($reviewers as $user) {
                Review::factory()->create([
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                ]);
            }
            
            $book->update(['rating' => $book->reviews()->avg('rating') ?? 0]);
        }
    }
}
