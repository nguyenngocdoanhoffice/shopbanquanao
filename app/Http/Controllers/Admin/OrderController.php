<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private array $statuses = ['pending', 'processing', 'shipping', 'completed', 'canceled'];

    public function index()
    {
        $orders = Order::with(['items.product', 'user'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->status === 'completed') {
            return back()->with('error', 'Đơn hàng đã hoàn thành nên không thể thay đổi trạng thái.');
        }

        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', $this->statuses)],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Order status updated.');
    }
}
