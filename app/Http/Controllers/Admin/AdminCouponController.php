<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(CouponRequest $request)
    {
        Coupon::create($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
