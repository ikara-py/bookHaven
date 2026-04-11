<?php
namespace App\Services;
 
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\FakeCard;
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
            $paymentStatus = 'pending';
            $orderStatus = 'pending';

            if ($data['payment_method'] === 'card') {
                $card = FakeCard::where('card_number', $data['card_number'])->first();

                if (!$card) {
                    throw new \Exception('Invalid card number. Please check your details.');
                }

                if ($card->expiry_date !== $data['expiry_date'] || $card->cvv !== $data['cvv']) {
                    throw new \Exception('Card security details (Expiry/CVV) do not match.');
                }

                if ($card->balance < $total) {
                    throw new \Exception('Insufficient funds on this card.');
                }

                $card->decrement('balance', $total);
                $paymentStatus = 'completed';
                $orderStatus = 'paid';
            }

            $order = Order::create([
                'user_id'          => $userId,
                'total_amount'     => $total,
                'status'           => $orderStatus,
                'shipping_address' => $data['shipping_address'],
            ]);
 
            foreach ($cart->items as $item) {
                $isDigital = $item->book->type === 'digital';
                
                OrderItem::create([
                    'order_id'  => $order->id,
                    'book_id'   => $item->book_id,
                    'seller_id' => $item->book->seller_id,
                    'quantity'  => $item->quantity,
                    'price'     => $item->price,
                    'status'    => $isDigital ? 'delivered' : 'pending',
                ]);
                
                if ($orderStatus === 'paid') {
                    $item->book->decrement('stock', $item->quantity);
                }
            }
 
            Payment::create([
                'order_id'       => $order->id,
                'amount'         => $total,
                'payment_method' => $data['payment_method'],
                'card_number'    => $data['payment_method'] === 'card' ? $data['card_number'] : null,
                'transaction_id' => $data['payment_method'] === 'card' ? 'sim_' . bin2hex(random_bytes(8)) : null,
            ]);
 
            $cart->items()->delete();

            $this->syncOrderStatus($order->id);
 
            return $order->refresh()->load('items.book', 'payment');
        });
    }
 
    public function cancelOrder(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            if (in_array($order->status, ['cancelled', 'completed'])) {
                throw new \Exception("Order #{$order->id} cannot be cancelled in its current state.");
            }

            $order->load('items.book');
            foreach ($order->items as $item) {
                if (in_array($order->status, ['paid', 'completed'])) {
                    $item->book->increment('stock', $item->quantity);
                }
            }

            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment && $payment->payment_method === 'card' && $payment->card_number) {
                $card = FakeCard::where('card_number', $payment->card_number)->first();
                if ($card) {
                    $card->increment('balance', $order->total_amount);
                    $payment->update(['status' => 'refunded']);
                }
            }

            $order->update(['status' => 'cancelled']);

            return $order->fresh();
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

    public function syncOrderStatus($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $totalItems = OrderItem::where('order_id', $orderId)->count();
        $deliveredItems = OrderItem::where('order_id', $orderId)
                                    ->where('status', 'delivered')
                                    ->count();
        
        if ($totalItems > 0 && $totalItems === $deliveredItems) {
            $order->update(['status' => 'completed']);
        }
    }
}