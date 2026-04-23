<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class UserCouponController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $coupons = Coupon::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now());
            })
            ->where(function ($query) use ($userId) {
                $query->where('apply_all', true)
                    ->orWhereHas('users', function ($builder) use ($userId) {
                        $builder->where('users.id', $userId);
                    });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('coupons.index', compact('coupons'));
    }
}
