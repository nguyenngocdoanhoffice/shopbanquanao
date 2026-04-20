@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Sản phẩm</h2>
            <p class="text-muted mb-0">Tìm món đồ yêu thích của bạn.</p>
        </div>
    </div>

    <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm mb-4">
        <form class="row g-3 align-items-end" method="get" action="{{ route('products.index') }}">
            <div class="col-12 col-md-6">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Tìm theo tên sản phẩm hoặc danh mục">
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-brand w-100" type="submit">Tìm</button>
            </div>
        </form>
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
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-brand btn-sm" href="{{ route('products.show', $product) }}">Xem chi tiết</a>
                            <button class="btn btn-brand btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $product->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                @if ($imageUrl)
                                    <img src="{{ $imageUrl }}" class="img-fluid rounded-3 mb-3" alt="{{ $product->name }}">
                                @endif
                                <p class="text-muted mb-2">{{ $product->category?->name }}</p>
                                <p class="fw-semibold">{{ number_format($product->price, 0) }} VND</p>
                                <p class="text-muted mb-0">{{ $product->description }}</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <button class="btn btn-brand" type="submit">Thêm vào giỏ</button>
                                </form>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không tìm thấy sản phẩm.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
