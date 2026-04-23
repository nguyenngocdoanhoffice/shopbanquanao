<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totals = $this->calculateTotals($cart);
        $coupon = session('coupon');

        return view('checkout.index', [
            'cart' => $cart,
            'subtotal' => $totals['subtotal'],
            'discount' => $totals['discount'],
            'total' => $totals['total'],
            'coupon' => $coupon,
        ]);
    }

    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function place(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        $totals = $this->calculateTotals($cart);
        $coupon = session('coupon');

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['quantity']) {
                return back()->with('error', 'Số lượng trong kho không đủ.');
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'total' => $totals['total'],
            'status' => 'pending',
            'coupon_code' => $coupon['code'] ?? null,
            'discount_amount' => $totals['discount'],
        ]);

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'import_price' => $product?->import_price ?? 0,
            ]);

            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        session()->forget('cart');
        session()->forget('coupon');
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('home')->with('success', 'Order placed successfully.');
    }

    private function calculateTotals(array $cart): array
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $coupon = session('coupon');
        if ($coupon) {
            if (!empty($coupon['discount_percent'])) {
                $discount = $subtotal * ($coupon['discount_percent'] / 100);
            } elseif (!empty($coupon['discount_amount'])) {
                $discount = $coupon['discount_amount'];
            }
        }

        $discount = min($discount, $subtotal);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
        ];
    }
}
