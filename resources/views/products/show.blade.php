@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                @php
                    $imageUrl = null;
                    if ($product->image) {
                        $imageUrl = \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : \Illuminate\Support\Facades\Storage::url($product->image);
                    }
                @endphp
                @if ($imageUrl)
                    <img src="{{ $imageUrl }}" class="img-fluid rounded-3" alt="{{ $product->name }}">
                @else
                    <div class="rounded-3" style="height: 320px; background: linear-gradient(135deg, rgba(15, 23, 42, 0.12), rgba(14, 165, 233, 0.18));"></div>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <span class="soft-pill">{{ $product->category?->name }}</span>
                <h2 class="mt-3 mb-2">{{ $product->name }}</h2>
                <p class="fw-semibold fs-4 mb-3">{{ number_format($product->price, 0) }} VND</p>
                <p class="text-muted mb-4">{{ $product->description }}</p>

                <form method="post" action="{{ route('cart.add', $product) }}" class="d-flex flex-wrap gap-2">
                    @csrf
                    <button class="btn btn-brand" type="submit">Add to cart</button>
                    <a class="btn btn-outline-brand" href="{{ route('products.index') }}">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
