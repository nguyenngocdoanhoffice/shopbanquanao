@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 p-lg-5 rounded-4 shadow-sm">
                <h2 class="mb-2">Chao mung quay lai</h2>
                <p class="text-muted mb-4">Dang nhap de tiep tuc mua sam.</p>
                <form method="post" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mat khau</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-brand" type="submit">Dang nhap</button>
                </form>
            </div>
        </div>
    </div>
@endsection
