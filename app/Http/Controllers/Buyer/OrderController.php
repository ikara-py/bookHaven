<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PlaceOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Exception;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService){}

    public function index(Request $request){
        $orders = $this->orderService->getUserOrders($request->user()->id);
        return view('orders.index', compact('orders'));
    }

    public function store(PlaceOrderRequest $request){
        $result = $this->orderService->placeOrder($request->user()->id, $request->validated());
        
        if ($result['redirect_url']) {
            return redirect()->away($result['redirect_url']);
        }

        return redirect()->route('orders.show', $result['order'])->with('success', 'Order placed successfully!');
    }

    public function show(Request $request, Order $order){
        if($order->user_id !== $request->user()->id){
            abort(403);
        }

        $order->load('items.book', 'payment');

        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        try {
            $this->orderService->cancelOrder($order);
            return redirect()->route('orders.show', $order)->with('success', 'Order cancelled successfully. Any payments have been refunded to your card.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
