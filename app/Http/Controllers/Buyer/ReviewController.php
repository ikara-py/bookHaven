<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use JonPurvis\Squeaky\Rules\Clean;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        if (!$book->isPurchasedBy($request->user()->id)) {
            return back()->with('error', 'You can only review books you have purchased once the order is delivered.');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000', new Clean()],
        ]);

        $book->reviews()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Your review has been submitted successfully!');
    }
}
