<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total'),
        ];

        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}
