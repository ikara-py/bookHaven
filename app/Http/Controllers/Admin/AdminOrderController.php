<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct(private AdminService $adminService){}

    public function index(){
        $orders = $this->adminService->allOrders();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order){
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,completed'
        ]);
        
        $this->adminService->updateOrderStatus($order, $request->status);
        return back()->with('success', 'Order status update');
    }
}
