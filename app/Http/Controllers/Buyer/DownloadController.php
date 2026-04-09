<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    public function download(Book $book)
    {
        if ($book->type !== 'digital') {
            abort(404, 'This product is not available for digital download.');
        }

        if (!$book->isPurchasedBy(Auth::id())) {
            abort(403, 'You must purchase this eBook to download it.');
        }

        if (!$book->pdf_path || !Storage::disk('public')->exists($book->pdf_path)) {
            return back()->with('error', 'The eBook file is currently unavailable. Please contact support.');
        }

        $book->increment('downloads');

        $fileName = Str::slug($book->title) . '.pdf';
        
        return Storage::disk('public')->download($book->pdf_path, $fileName);
    }
}
