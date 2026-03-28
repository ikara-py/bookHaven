<?php

namespace App\Services;

use App\Models\User;
use App\Models\SellerProfile;
use App\Models\Order;
use App\Models\Book;

class AdminService
{
    public function allUsers()
    {
        return User::with('sellerProfile')->latest()->paginate(30);
    }

    public function updateStatus($userId, $status)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => $status]);
        return $user;
    }

    public function updateRole($userId, $role)
    {
        $user = User::findOrFail($userId);
        $user->update(['role' => $role]);
        return $user;
    }

    public function approveSeller($userId): SellerProfile
    {
        $profile = SellerProfile::where('user_id', $userId)->firstOrFail();
        $profile->update(['is_approved' => true]);
        return $profile;
    }

    public function stats()
    {
        return [
            'total_users'     => User::count(),
            'total_sellers'   => User::whereIn('role', ['seller','buyer_seller'])->count(),
            'total_books'     => Book::count(),
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::where('status','completed')->sum('total_amount'),
            'pending_orders'  => Order::where('status','pending')->count(),
            'pending_sellers' => SellerProfile::where('is_approved', false)->count(),
        ];
    }

    public function allOrders()
    {
        return Order::with('user', 'items.book', 'payment')->latest()->paginate(30);
    }

    public function updateOrderStatus(Order $order, $status)
    {
        $order->update(['status' => $status]);
        return $order->fresh();
    }
}
