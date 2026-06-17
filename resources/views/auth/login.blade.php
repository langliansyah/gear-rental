@extends('layouts.app')

@section('title', 'Login - Gear Rental')

@section('content')
<div class="container">
    <div class="auth-form">
        <h1>Login</h1>
        <p class="subtitle">Sistem Peminjaman Peralatan Pendakian</p>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="text-center mt-3" style="font-size: 0.9rem; color: #ABABAB;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: #E9663C; font-weight: 600;">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection