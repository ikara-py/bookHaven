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
        return view('admin.dashboard', compact('status'));
    }

    public function index(){
        $users = $this->adminService->allUsers();
        return view('admin.users.index', compact('users'));
    }

    public function updateStatus(Request $request, $userId){
        if ($userId == auth()->id()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        $request->validate([
            'status' => ['required', 'in:active,suspended']
        ]);

        $this->adminService->updateStatus($userId, $request->status);
        return back()->with('success', 'User status updated');
    }

    public function updateRole(Request $request, $userId){
        if ($userId == auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $request->validate(['role' => ['required', 'in:buyer,seller,buyer_seller,admin']]);
        $this->adminService->updateRole($userId, $request->role);
        return back()->with('success', 'User role updated.');
    }

    public function approveSeller($userId){
        $this->adminService->approveSeller($userId);
        return back()->with('success', 'Seller profile approved successfully.');
    }
}
