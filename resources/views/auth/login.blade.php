@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow-lg p-4">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                        <i class="fa-solid fa-user-lock fa-2x text-primary"></i>
                    </div>
                    <h3 class="fw-bold">Login to Account</h3>
                    <p class="text-muted small">Enter your credentials to access the dashboard</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@example.com" required>
                        </div>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-key text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm" style="border-radius: 10px;">
                        Sign In<i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection