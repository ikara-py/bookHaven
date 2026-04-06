<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\SellerService;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function __construct(private SellerService $sellerService){}

    public function index()
    {
        $stats = $this->sellerService->getDashboardStats(Auth::id());
        return view('seller.dashboard', compact('stats'));
    }
}
