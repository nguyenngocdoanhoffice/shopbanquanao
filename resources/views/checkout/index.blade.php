@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Thanh toan</h2>
            <p class="text-muted mb-0">Nhap thong tin giao hang.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <form method="post" action="{{ route('checkout.place') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Dia chi</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">So dien thoai</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                    <button class="btn btn-brand" type="submit">Dat hang</button>
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h5>Tom tat don hang</h5>
                <ul class="list-group list-group-flush mb-3">
                    @foreach ($cart as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                            <span>{{ number_format($item['price'] * $item['quantity'], 0) }} VND</span>
                        </li>
                    @endforeach
                </ul>
                <p class="mb-1">Tạm tính: <strong>{{ number_format($subtotal, 0) }} VND</strong></p>
                <p class="mb-1">Giảm giá: <strong>{{ number_format($discount, 0) }} VND</strong></p>
                @if ($coupon)
                    <p class="mb-1 text-muted">Mã: {{ $coupon['code'] }}</p>
                @endif
                <p class="mb-0">Tổng: <strong>{{ number_format($total, 0) }} VND</strong></p>
            </div>
        </div>
    </div>
@endsection
