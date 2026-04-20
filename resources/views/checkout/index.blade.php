@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Checkout</h2>
            <p class="text-muted mb-0">Provide delivery information.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <form method="post" action="{{ route('checkout.place') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                    <button class="btn btn-brand" type="submit">Place order</button>
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h5>Order summary</h5>
                <ul class="list-group list-group-flush mb-3">
                    @foreach ($cart as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                            <span>{{ number_format($item['price'] * $item['quantity'], 0) }} VND</span>
                        </li>
                    @endforeach
                </ul>
                <p class="mb-0">Total: <strong>{{ number_format($total, 0) }} VND</strong></p>
            </div>
        </div>
    </div>
@endsection
