<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct(private AdminService $adminService){}

    public function dashboard(){
        $status = $this->adminService->stats();
        dd($status);
    }

    public function index(){
        $users = $this->adminService->allUsers();
        dd($users);
    }

    public function updateStatus(Request $request, $userId){
        $request->validate([
            'status' => 'required|in:active,suspended'
        ]);

        $this->adminService->updateStatus($userId, $request->status);
        return back()->with('success', 'User status updated');
    }

    public function updateRole(Request $request, $userId){
        $request->validate(['role' => 'required|in:buyer,seller,buyer_seller,admin']);
        $this->adminService->updateRole($userId, $request->role);
        return back()->with('success', 'seller approved.');
    }
}
