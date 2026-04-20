@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Edit product</h2>
        <p class="text-muted mb-0">Update details and pricing.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.products.update', $product) }}">
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
                <label class="form-label">Image URL</label>
                <input type="text" name="image" class="form-control" value="{{ old('image', $product->image) }}">
            </div>
            <button class="btn btn-dark" type="submit">Update</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Cancel</a>
        </form>
    </div>
@endsection
