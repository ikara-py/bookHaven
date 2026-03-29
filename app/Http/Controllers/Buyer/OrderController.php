<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PlaceOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService){}

    public function index(Request $request){
        $orders = $this->orderService->getUserOrders($request->user()->id);
        //dd(orders);
        return view('orders.index', compact('orders'));
    }

    public function store(PlaceOrderRequest $request){
        $order = $this->orderService->placeOrder($request->user()->id, $request->validated());
        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }

    public function show(Request $request, Order $order){
        if($order->user_id !== $request->user()->id){
            abort(403);
        }

        dd($order->load('items.book', 'payment'));

        // return view('order.show', );
    }


}
