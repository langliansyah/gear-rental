@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('pelanggan.dashboard') }}">
            <i class="bi bi-box"></i> Gear Rental
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.dashboard') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.keranjang') }}">Keranjang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.riwayat') }}">Riwayat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('pelanggan.profil') }}">Profil</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-5">
    <a href="{{ route('pelanggan.profil') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Profil
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="auth-form">
                <h1>Ganti Password</h1>
                <p class="subtitle">Demi keamanan, gunakan password yang kuat.</p>

                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        @foreach($errors->all() as $err)
                            <p class="mb-0">{{ $err }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('pelanggan.profil.password.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password_lama" class="form-label fw-semibold">Password Lama</label>
                        <input type="password" id="password_lama" name="password_lama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label fw-semibold">Password Baru</label>
                        <input type="password" id="password_baru" name="password_baru" class="form-control" required>
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ganti Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Gear Rental. All rights reserved.</p>
    </div>
</footer>
@endsection