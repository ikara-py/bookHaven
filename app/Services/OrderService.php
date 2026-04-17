<?php
namespace App\Services;
 
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Refund;
use Stripe\Exception\ApiErrorException;
use Exception;
 
class OrderService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function placeOrder(int $userId, array $data): array
    {
        return DB::transaction(function () use ($userId, $data) {
            $cart = Cart::with('items.book')
                        ->where('user_id', $userId)->firstOrFail();
 
            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Cannot place an order with an empty cart.'
                ]);
            }
 
            $total = $cart->items->sum(fn($i) => $i->price * $i->quantity);
            $orderStatus = 'pending';

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
            }
 
            $payment = Payment::create([
                'order_id'       => $order->id,
                'amount'         => $total,
                'payment_method' => $data['payment_method'],
                'status'         => 'pending',
            ]);

            $sessionUrl = null;
            if ($data['payment_method'] === 'stripe') {
                $session = $this->createCheckoutSession($order);
                $payment->update(['transaction_id' => $session->id]);
                $sessionUrl = $session->url;
            } else {
                $this->syncOrderStatus($order->id);
            }

            $cart->items()->delete();
 
            return [
                'order' => $order->refresh()->load('items.book', 'payment'),
                'redirect_url' => $sessionUrl
            ];
        });
    }

    protected function createCheckoutSession(Order $order): CheckoutSession
    {
        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->book->title,
                    ],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        return CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('orders.show', $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('orders.index'),
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);
    }
 
    public function cancelOrder(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            if (in_array($order->status, ['cancelled', 'completed'])) {
                throw new Exception("Order #{$order->id} cannot be cancelled in its current state.");
            }

            $order->load('items.book');
            foreach ($order->items as $item) {
                if (in_array($order->status, ['paid', 'completed'])) {
                    $item->book->increment('stock', $item->quantity);
                }
            }

            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment && $payment->payment_method === 'stripe' && $payment->transaction_id) {
                try {
                    $refundId = $payment->transaction_id;

                    if (str_starts_with($refundId, 'cs_')) {
                        $session = CheckoutSession::retrieve($refundId);
                        $refundId = $session->payment_intent;
                    }

                    Refund::create([
                        'payment_intent' => $refundId,
                    ]);
                    $payment->update(['status' => 'refunded']);
                } catch (ApiErrorException $e) {
                    Log::error('Stripe Refund Failed: ' . $e->getMessage());
                    throw new Exception('Failed to process the refund with Stripe: ' . $e->getMessage());
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