<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function destroy(Review $review)
    {
        $book = $review->book;
        $review->delete();
        
        $newAverage = $book->reviews()->avg('rating');
        $book->update(['rating' => $newAverage ?? 0]);
        
        return back()->with('success', 'Review deleted successfully.');
    }
}
