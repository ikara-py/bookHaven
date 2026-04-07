<?php

namespace App\Services;

use App\Models\Book;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class SellerService
{
    public function getDashboardStats($sellerId)
    {
        return [
            'total_books' => Book::where('seller_id', $sellerId)->count(),
            'pending_orders' => OrderItem::where('seller_id', $sellerId)
                ->where('status', 'pending')
                ->count(),
            'total_earnings' => OrderItem::where('seller_id', $sellerId)
                ->whereIn('status', ['completed', 'shipped'])
                ->sum(DB::raw('price * quantity')),
            'recent_sales' => OrderItem::with(['book', 'order.user'])
                ->where('seller_id', $sellerId)
                ->latest()
                ->limit(5)
                ->get()
        ];
    }
}
