<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::with('category')->latest()->take(8)->get();
        $coupons = [];

        if (Auth::check()) {
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
        }

        return view('home', compact('products', 'coupons'));
    }

    public function index(Request $request)
    {
        $query = Product::with('category')->latest();
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhereHas('category', function ($builder) use ($keyword) {
                    $builder->where('name', 'like', "%{$keyword}%");
                });
        }

        $products = $query->paginate(12)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
