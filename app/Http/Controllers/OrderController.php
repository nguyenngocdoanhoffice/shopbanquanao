<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
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

        $total = $this->cartTotal($cart);

        return view('checkout.index', compact('cart', 'total'));
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

        $total = $this->cartTotal($cart);

        // Create the order header first.
        $order = Order::create([
            'user_id' => Auth::id(),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'total' => $total,
            'status' => 'pending',
        ]);

        // Then create each order item from the session cart.
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('home')->with('success', 'Order placed successfully.');
    }

    private function cartTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }
}
