<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Store cart data in session for a simple example.
        $cart = session()->get('cart', []);
        $total = $this->cartTotal($cart);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:20'],
        ]);

        // Use product id as the session key.
        $cart = session()->get('cart', []);
        $quantity = $data['quantity'] ?? 1;
        $size = $data['size'] ?? null;

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
            $cart[$product->id]['size'] = $size ?? $cart[$product->id]['size'];
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'size' => $size,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $data['quantity'];
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed.');
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
