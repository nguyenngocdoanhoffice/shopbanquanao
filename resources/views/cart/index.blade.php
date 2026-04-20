@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Your cart</h2>
            <p class="text-muted mb-0">Review items before checkout.</p>
        </div>
    </div>

    @if (empty($cart))
        <p class="text-muted">Your cart is empty.</p>
    @else
        <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm mb-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th width="140">Price</th>
                            <th width="160">Quantity</th>
                            <th width="160">Subtotal</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price'], 0) }} VND</td>
                                <td>
                                    <form method="post" action="{{ route('cart.update', $item['id']) }}" class="d-flex gap-2">
                                        @csrf
                                        <input type="number" name="quantity" class="form-control" value="{{ $item['quantity'] }}" min="1">
                                        <button class="btn btn-outline-brand btn-sm" type="submit">Update</button>
                                    </form>
                                </td>
                                <td>{{ number_format($item['price'] * $item['quantity'], 0) }} VND</td>
                                <td>
                                    <form method="post" action="{{ route('cart.remove', $item['id']) }}">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <p class="mb-2">Total: <strong>{{ number_format($total, 0) }} VND</strong></p>
                <a class="btn btn-brand" href="{{ route('checkout.index') }}">Checkout</a>
            </div>
        </div>
    @endif
@endsection
