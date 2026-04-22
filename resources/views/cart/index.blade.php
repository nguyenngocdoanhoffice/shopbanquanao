@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Giỏ hàng của bạn</h2>
            <p class="text-muted mb-0">Kiểm tra sản phẩm trước khi thanh toán.</p>
        </div>
    </div>

    @if (empty($cart))
        <p class="text-muted">Giỏ hàng đang trống.</p>
    @else
        <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm mb-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th width="120">Kích cỡ</th>
                            <th width="140">Giá</th>
                            <th width="160">Số lượng</th>
                            <th width="160">Tạm tính</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['size'] ?? 'Freesize' }}</td>
                                <td>{{ number_format($item['price'], 0) }} VND</td>
                                <td>
                                    <form method="post" action="{{ route('cart.update', $item['id']) }}" class="d-flex gap-2">
                                        @csrf
                                        <input type="number" name="quantity" class="form-control" value="{{ $item['quantity'] }}" min="1">
                                        <button class="btn btn-outline-brand btn-sm" type="submit">Cập nhật</button>
                                    </form>
                                </td>
                                <td>{{ number_format($item['price'] * $item['quantity'], 0) }} VND</td>
                                <td>
                                    <form method="post" action="{{ route('cart.remove', $item['id']) }}">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-12 col-lg-5">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h6 class="mb-3">Mã giảm giá</h6>
                    @if ($coupon)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">{{ $coupon['code'] }}</span>
                            <form method="post" action="{{ route('cart.coupon.remove') }}">
                                @csrf
                                <button class="btn btn-outline-secondary btn-sm" type="submit">Xóa</button>
                            </form>
                        </div>
                    @else
                        <form method="post" action="{{ route('cart.coupon.apply') }}" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="code" class="form-control" placeholder="Nhập mã">
                            <button class="btn btn-outline-brand" type="submit">Áp dụng</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <p class="mb-2">Tạm tính: <strong>{{ number_format($subtotal, 0) }} VND</strong></p>
                    <p class="mb-2">Giảm giá: <strong>{{ number_format($discount, 0) }} VND</strong></p>
                    <p class="mb-3">Tổng: <strong>{{ number_format($total, 0) }} VND</strong></p>
                    <a class="btn btn-brand w-100" href="{{ route('checkout.index') }}">Thanh toán</a>
                </div>
            </div>
        </div>
    @endif
@endsection
