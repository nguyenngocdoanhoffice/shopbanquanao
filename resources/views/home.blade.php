@extends('layouts.app')

@section('content')
    <div class="row align-items-center g-4 mb-4 mb-lg-5">
        <div class="col-12 col-lg-6">
            <div class="p-4 p-lg-5 bg-white rounded-4 shadow-sm fade-up" style="--delay: 0s;">
                <span class="soft-pill">New collection 2026</span>
                <h1 class="mt-3 mb-3">Modern outfits for everyday confidence</h1>
                <p class="text-muted mb-4">Pick outfits that feel good and look sharp. Curated basics, denim, and cozy layers.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-brand" href="{{ route('products.index') }}">Shop now</a>
                    <a class="btn btn-outline-brand" href="{{ route('cart.index') }}">View cart</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="p-4 p-lg-5 rounded-4 text-white fade-up" style="--delay: 0.1s; background: linear-gradient(135deg, #0f172a, #1f2937);">
                <h4 class="mb-2">Fast pickup & easy returns</h4>
                <p class="mb-0 text-white-50">Try styles at home, exchange in 7 days with no stress.</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Newest products</h3>
        <a class="btn btn-outline-brand btn-sm" href="{{ route('products.index') }}">View all</a>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-product h-100 fade-up" style="--delay: {{ $loop->index * 0.05 }}s;">
                    <div class="card-body">
                        <span class="soft-pill">{{ $product->category?->name }}</span>
                        <h5 class="card-title mt-3">{{ $product->name }}</h5>
                        <p class="fw-semibold mb-3">{{ number_format($product->price, 0) }} VND</p>
                        <a class="btn btn-outline-brand btn-sm" href="{{ route('products.show', $product) }}">View details</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No products yet.</p>
        @endforelse
    </div>
@endsection
