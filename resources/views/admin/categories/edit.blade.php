@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Edit category</h2>
        <p class="text-muted mb-0">Rename category and save changes.</p>
    </div>

    <div class="admin-card p-4">
        <form method="post" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <button class="btn btn-dark" type="submit">Update</button>
            <a class="btn btn-outline-secondary" href="{{ route('admin.categories.index') }}">Cancel</a>
        </form>
    </div>
@endsection
