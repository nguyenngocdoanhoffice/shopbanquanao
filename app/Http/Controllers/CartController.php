<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coupon;
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
        $totals = $this->calculateTotals($cart);
        $coupon = session('coupon');

        return view('cart.index', [
            'cart' => $cart,
            'subtotal' => $totals['subtotal'],
            'discount' => $totals['discount'],
            'total' => $totals['total'],
            'coupon' => $coupon,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:20'],
        ]);

        $maxQty = 500;
        $quantity = $data['quantity'] ?? 1;
        $size = $data['size'] ?? null;

        if ($product->stock <= 0) {
            return back()->with('error', 'Sản phẩm đã hết hàng.');
        }

        if (Auth::check()) {
            $item = CartItem::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            $currentQty = $item->quantity ?? 0;
            $desiredQty = $currentQty + $quantity;
            $allowedMax = min($maxQty, $product->stock);
            if ($desiredQty > $allowedMax) {
                if ($product->stock < $maxQty) {
                    return back()->with('error', 'Chỉ được mua với số lượng cho phép: ' . $product->stock . '.');
                }
                return back()->with('error', 'Chỉ được phép mua tối đa 500 sản phẩm.');
            }
            $item->quantity = $desiredQty;
            $item->size = $size ?? $item->size;
            $item->save();

            $this->loadUserCartToSession();
        } else {
            // Use product id as the session key for guests.
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $desiredQty = $cart[$product->id]['quantity'] + $quantity;
                $allowedMax = min($maxQty, $product->stock);
                if ($desiredQty > $allowedMax) {
                    if ($product->stock < $maxQty) {
                        return back()->with('error', 'Chỉ được mua với số lượng cho phép: ' . $product->stock . '.');
                    }
                    return back()->with('error', 'Chỉ được phép mua tối đa 500 sản phẩm.');
                }
                $cart[$product->id]['quantity'] = $desiredQty;
                $cart[$product->id]['size'] = $size ?? $cart[$product->id]['size'];
            } else {
                $allowedMax = min($maxQty, $product->stock);
                if ($quantity > $allowedMax) {
                    if ($product->stock < $maxQty) {
                        return back()->with('error', 'Chỉ được mua với số lượng cho phép: ' . $product->stock . '.');
                    }
                    return back()->with('error', 'Chỉ được phép mua tối đa 500 sản phẩm.');
                }
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

        $maxQty = 500;
        $allowedMax = min($maxQty, $product->stock);
        if ($data['quantity'] > $allowedMax) {
            if ($product->stock < $maxQty) {
                return back()->with('error', 'Chỉ được mua với số lượng cho phép: ' . $product->stock . '.');
            }
            return back()->with('error', 'Chỉ được phép mua tối đa 500 sản phẩm.');
        }

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

    public function applyCoupon(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $coupon = Coupon::where('code', $data['code'])
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now());
            })
            ->first();

        if (! $coupon) {
            return back()->with('error', 'Mã giảm giá không hợp lệ.');
        }

        if (Auth::check()) {
            if (! $coupon->apply_all && ! $coupon->users()->where('users.id', Auth::id())->exists()) {
                return back()->with('error', 'Mã giảm giá không áp dụng cho tài khoản này.');
            }
        } elseif (! $coupon->apply_all) {
            return back()->with('error', 'Mã giảm giá này chỉ áp dụng cho khách hàng được chọn.');
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount_percent' => $coupon->discount_percent,
            'discount_amount' => $coupon->discount_amount,
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');

        return back()->with('success', 'Đã xóa mã giảm giá.');
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
