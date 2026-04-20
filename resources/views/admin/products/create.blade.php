@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Add product</h2>
        <p class="text-muted mb-0">Fill product information for the catalog.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id" required>
                    <option value="">Choose category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image URL</label>
                <input type="text" name="image" class="form-control" value="{{ old('image') }}">
            </div>
            <button class="btn btn-dark" type="submit">Save</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Cancel</a>
        </form>
    </div>
@endsection
