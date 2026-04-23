@extends('layouts.app')

@section('content')
    <div class="row align-items-center g-4 mb-4 mb-lg-5">
        <div class="col-12 col-lg-6">
            <div class="p-4 p-lg-5 bg-white rounded-4 shadow-sm fade-up" style="--delay: 0s;">
                <span class="soft-pill">Bộ sưu tập mới 2026</span>
                <h1 class="mt-3 mb-3">Trang phục hiện đại cho mỗi ngày</h1>
                <p class="text-muted mb-4">Chọn đồ mặc thoải mái và tự tin. Bộ sưu tập cơ bản, denim và đồ ấm áp.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-brand" href="{{ route('products.index') }}">Mua ngay</a>
                    <a class="btn btn-outline-brand" href="{{ route('cart.index') }}">Xem giỏ hàng</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="p-4 p-lg-5 rounded-4 text-white fade-up" style="--delay: 0.1s; background: linear-gradient(135deg, #0f172a, #1f2937);">
                <h4 class="mb-2">Nhận hàng nhanh & đổi trả dễ dàng</h4>
                <p class="mb-0 text-white-50">Thử đồ tại nhà, đổi trả trong 7 ngày.</p>
            </div>
        </div>
    </div>

    @auth
        @if (!empty($coupons) && $coupons->isNotEmpty())
            <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Mã giảm giá dành cho bạn</h4>
                    <a class="btn btn-outline-brand btn-sm" href="{{ route('coupons.index') }}">Xem tất cả</a>
                </div>
                <div class="row g-3">
                    @foreach ($coupons->take(4) as $coupon)
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="p-3 rounded-4" style="background: rgba(15, 23, 42, 0.04);">
                                <div class="fw-semibold">{{ $coupon->code }}</div>
                                <div class="text-muted small">
                                    @if ($coupon->discount_percent)
                                        Giảm {{ $coupon->discount_percent }}%
                                    @elseif ($coupon->discount_amount)
                                        Giảm {{ number_format($coupon->discount_amount, 0) }} VND
                                    @else
                                        Ưu đãi đặc biệt
                                    @endif
                                </div>
                                @if ($coupon->expired_at)
                                    <div class="text-muted small">Hết hạn: {{ $coupon->expired_at->format('Y-m-d') }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endauth

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Sản phẩm mới</h3>
        <a class="btn btn-outline-brand btn-sm" href="{{ route('products.index') }}">Xem tất cả</a>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-12 col-md-6 col-lg-3">
                @php
                    $imageUrl = null;
                    if ($product->image) {
                        $imageUrl = \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : \Illuminate\Support\Facades\Storage::url($product->image);
                    }
                @endphp
                <div class="card card-product h-100 fade-up" style="--delay: {{ $loop->index * 0.05 }}s;">
                    @if ($imageUrl)
                        <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="rounded-top" style="height: 160px; background: linear-gradient(135deg, rgba(15, 23, 42, 0.12), rgba(14, 165, 233, 0.18));"></div>
                    @endif
                    <div class="card-body">
                        <span class="soft-pill">{{ $product->category?->name }}</span>
                        <h5 class="card-title mt-3">{{ $product->name }}</h5>
                        <p class="fw-semibold mb-3">{{ number_format($product->price, 0) }} VND</p>
                        @if ($product->stock === 0)
                            <span class="badge bg-secondary">Hết hàng</span>
                        @endif
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-brand btn-sm" href="{{ route('products.show', $product) }}">Xem chi tiết</a>
                            <button class="btn btn-brand btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}" @disabled($product->stock === 0)>
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $product->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <form method="post" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <div class="modal-body">
                                    @if ($imageUrl)
                                        <img src="{{ $imageUrl }}" class="img-fluid rounded-3 mb-3" alt="{{ $product->name }}">
                                    @endif
                                    <p class="text-muted mb-2">{{ $product->category?->name }}</p>
                                    <p class="fw-semibold">{{ number_format($product->price, 0) }} VND</p>
                                    <p class="text-muted">{{ $product->description }}</p>
                                    @php
                                        $sizes = collect(explode(',', (string) $product->size))
                                            ->map(fn ($size) => trim($size))
                                            ->filter();
                                    @endphp
                                    <div class="row g-3 mt-2">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Kích cỡ</label>
                                            <select name="size" class="form-select" @disabled($sizes->isEmpty())>
                                                @if ($sizes->isEmpty())
                                                    <option value="">Freesize</option>
                                                @else
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size }}">{{ $size }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-brand" type="submit" @disabled($product->stock === 0)>Thêm vào giỏ</button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Chưa có sản phẩm.</p>
        @endforelse
    </div>
@endsection
