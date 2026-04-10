<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Services\OrderService;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function __construct(private OrderService $orderService){}

    public function index(Request $request){
        $items = $this->orderService->getSellerOrders($request->user()->id);

        return view('seller.orders.index', compact('items'));
    }

    public function updateStatus(Request $request, OrderItem $item){
        if($item->seller_id !== $request->user()->id){
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:pending,shipped,delivered']
        ]);

        $item->update(['status' => $request->status]);
        $this->orderService->syncOrderStatus($item->order_id);
        
        return back()->with('success', 'Order item status updated');
    }
}
