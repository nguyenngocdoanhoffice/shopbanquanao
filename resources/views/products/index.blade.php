@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-1">Products</h2>
            <p class="text-muted mb-0">Find your next favorite outfit.</p>
        </div>
    </div>

    <div class="bg-white p-3 p-lg-4 rounded-4 shadow-sm mb-4">
        <form class="row g-3 align-items-end" method="get" action="{{ route('products.index') }}">
            <div class="col-12 col-md-5">
                <label class="form-label">Category</label>
                <select class="form-select" name="category">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-brand w-100" type="submit">Apply filter</button>
            </div>
        </form>
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
            <p class="text-muted">No products found.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
