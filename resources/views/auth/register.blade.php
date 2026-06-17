@extends('layouts.app')

@section('title', 'Register - Gear Rental')

@section('content')
<div class="container">
    <div class="auth-form">
        <h1>Daftar Akun</h1>
        <p class="subtitle">Sistem Peminjaman Peralatan Pendakian</p>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                @error('full_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <small class="text-muted">Minimal 8 karakter</small>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>

        <p class="text-center mt-3" style="font-size: 0.9rem; color: #ABABAB;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: #E9663C; font-weight: 600;">Login di sini</a>
        </p>
    </div>
</div>
@endsection