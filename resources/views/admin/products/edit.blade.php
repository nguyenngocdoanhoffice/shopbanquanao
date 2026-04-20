@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Edit product</h2>
        <p class="text-muted mb-0">Update details and pricing.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($product->category_id === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Sizes (comma separated)</label>
                <input type="text" name="size" class="form-control" value="{{ old('size', $product->size) }}" placeholder="S, M, L, XL">
            </div>
            <div class="mb-3">
                <label class="form-label">Product image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if ($product->image)
                    @php
                        $imageUrl = \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : \Illuminate\Support\Facades\Storage::url($product->image);
                    @endphp
                    <img src="{{ $imageUrl }}" class="img-fluid rounded-3 mt-3" style="max-height: 200px;" alt="{{ $product->name }}">
                @endif
            </div>
            <button class="btn btn-dark" type="submit">Update</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Cancel</a>
        </form>
    </div>
@endsection
