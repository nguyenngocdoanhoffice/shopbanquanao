<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
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
        $users = User::query()
            ->withCount('orders')
            ->withSum(['orders as total_spent' => fn ($query) => $query->where('status', 'completed')], 'total')
            ->orderBy('name')
            ->get();

        return view('admin.coupons.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:100'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'expired_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'apply_all' => ['nullable', 'boolean'],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $hasPercent = !empty($data['discount_percent']);
        $hasAmount = !empty($data['discount_amount']);

        if (!$hasPercent && !$hasAmount) {
            return back()->with('error', 'Cần nhập % hoặc số tiền giảm.');
        }

        if ($hasPercent && $hasAmount) {
            return back()->with('error', 'Chỉ được chọn một kiểu giảm giá: % hoặc số tiền.');
        }

        $coupon = Coupon::create([
            'code' => $data['code'],
            'discount_percent' => $data['discount_percent'] ?? null,
            'discount_amount' => $data['discount_amount'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? false),
            'apply_all' => (bool) ($data['apply_all'] ?? false),
        ]);

        if (empty($data['apply_all'])) {
            $coupon->users()->sync($data['user_ids'] ?? []);
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công.');
    }

    public function edit(Coupon $coupon)
    {
        $users = User::query()
            ->withCount('orders')
            ->withSum(['orders as total_spent' => fn ($query) => $query->where('status', 'completed')], 'total')
            ->orderBy('name')
            ->get();

        $selectedUsers = $coupon->users()->pluck('users.id')->all();

        return view('admin.coupons.edit', compact('coupon', 'users', 'selectedUsers'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code,' . $coupon->id],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:100'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'expired_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'apply_all' => ['nullable', 'boolean'],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $hasPercent = !empty($data['discount_percent']);
        $hasAmount = !empty($data['discount_amount']);

        if (!$hasPercent && !$hasAmount) {
            return back()->with('error', 'Cần nhập % hoặc số tiền giảm.');
        }

        if ($hasPercent && $hasAmount) {
            return back()->with('error', 'Chỉ được chọn một kiểu giảm giá: % hoặc số tiền.');
        }

        $coupon->update([
            'code' => $data['code'],
            'discount_percent' => $data['discount_percent'] ?? null,
            'discount_amount' => $data['discount_amount'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? false),
            'apply_all' => (bool) ($data['apply_all'] ?? false),
        ]);

        if (!empty($data['apply_all'])) {
            $coupon->users()->sync([]);
        } else {
            $coupon->users()->sync($data['user_ids'] ?? []);
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Xóa mã giảm giá thành công.');
    }
}
