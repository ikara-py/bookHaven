<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function destroy(Review $review)
    {
        $review->delete();
        
        return back()->with('success', 'Review deleted successfully.');
    }
}
