<?php
namespace App\Services;
 
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
 
class OrderService
{
    public function placeOrder(int $userId, array $data): Order
    {
        return DB::transaction(function () use ($userId, $data) {
            $cart = Cart::with('items.book')
                        ->where('user_id', $userId)->firstOrFail();
 
            if ($cart->items->isEmpty()) {
                throw new \Exception('Cannot place an order with an empty cart.');
            }
 
            $total = $cart->items->sum(fn($i) => $i->price * $i->quantity);
 
            $order = Order::create([
                'user_id'          => $userId,
                'total_amount'     => $total,
                'status'           => 'pending',
                'shipping_address' => $data['shipping_address'],
            ]);
 
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'book_id'   => $item->book_id,
                    'seller_id' => $item->book->seller_id,
                    'quantity'  => $item->quantity,
                    'price'     => $item->price,
                    'status'    => 'pending',
                ]);
                $item->book->decrement('stock', $item->quantity);
            }
 
            Payment::create([
                'order_id'       => $order->id,
                'amount'         => $total,
                'payment_method' => $data['payment_method'],
                'status'         => 'pending',
            ]);
 
            $cart->items()->delete();
 
            return $order->load('items.book', 'payment');
        });
    }
 
    public function getUserOrders(int $userId)
    {
        return Order::with('items.book', 'payment')
                    ->where('user_id', $userId)->latest()->get();
    }
 
    public function getSellerOrders(int $sellerId)
    {
        return OrderItem::with('order.user', 'book')
                        ->where('seller_id', $sellerId)->latest()->get();
    }
}