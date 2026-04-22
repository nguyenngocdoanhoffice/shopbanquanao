<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderByDesc('created_at')->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:100'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'expired_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($data['discount_percent']) && empty($data['discount_amount'])) {
            return back()->with('error', 'Cần nhập % hoặc số tiền giảm.');
        }

        Coupon::create([
            'code' => $data['code'],
            'discount_percent' => $data['discount_percent'] ?? null,
            'discount_amount' => $data['discount_amount'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code,' . $coupon->id],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:100'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'expired_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($data['discount_percent']) && empty($data['discount_amount'])) {
            return back()->with('error', 'Cần nhập % hoặc số tiền giảm.');
        }

        $coupon->update([
            'code' => $data['code'],
            'discount_percent' => $data['discount_percent'] ?? null,
            'discount_amount' => $data['discount_amount'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Xóa mã giảm giá thành công.');
    }
}
