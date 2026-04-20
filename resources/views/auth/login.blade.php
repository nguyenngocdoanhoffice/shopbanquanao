@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="bg-white p-4 p-lg-5 rounded-4 shadow-sm">
                <h2 class="mb-2">Welcome back</h2>
                <p class="text-muted mb-4">Login to continue shopping.</p>
                <form method="post" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-brand" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
