<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::check()
            ? $this->loadUserCartToSession()
            : session()->get('cart', []);
        $total = $this->cartTotal($cart);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:20'],
        ]);

        $quantity = $data['quantity'] ?? 1;
        $size = $data['size'] ?? null;

        if (Auth::check()) {
            $item = CartItem::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            $item->quantity = ($item->quantity ?? 0) + $quantity;
            $item->size = $size ?? $item->size;
            $item->save();

            $this->loadUserCartToSession();
        } else {
            // Use product id as the session key for guests.
            $cart = session()->get('cart', []);

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
        }

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->update(['quantity' => $data['quantity']]);
            $this->loadUserCartToSession();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] = $data['quantity'];
                session()->put('cart', $cart);
            }
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->delete();
            $this->loadUserCartToSession();
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                unset($cart[$product->id]);
                session()->put('cart', $cart);
            }
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

    private function loadUserCartToSession(): array
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $cart = [];
        foreach ($items as $item) {
            if (!$item->product) {
                continue;
            }
            $cart[$item->product_id] = [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'size' => $item->size,
            ];
        }

        session()->put('cart', $cart);

        return $cart;
    }
}
