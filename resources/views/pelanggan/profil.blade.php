@extends('layouts.app')

@section('title', 'Profil Saya')

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
                    <a class="nav-link" href="{{ route('pelanggan.keranjang') }}">
                        Keranjang
                        @php $count = count(session('keranjang', [])); @endphp
                        @if($count > 0)
                            <span class="badge bg-warning text-dark ms-1">{{ $count }}</span>
                        @endif
                    </a>
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
    <div class="mb-5">
        <h1 class="display-5 fw-bold mb-2">Profil Saya</h1>
        <p class="text-muted">Kelola informasi akunmu.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="profile-card text-center">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                </div>
                <h2 class="fw-bold mb-1">{{ $user->full_name }}</h2>
                <span class="badge bg-primary mb-4">{{ ucfirst($user->role) }}</span>

                <div class="text-start mt-4">
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <span class="text-muted">Username</span>
                        <strong>{{ $user->username }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <span class="text-muted">Nama Lengkap</span>
                        <strong>{{ $user->full_name }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <span class="text-muted">Role</span>
                        <strong>{{ ucfirst($user->role) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tanggal Daftar</span>
                        <strong>{{ $user->created_at->format('d F Y') }}</strong>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('pelanggan.profil.edit') }}" class="btn btn-primary flex-fill">
                        <i class="bi bi-pencil"></i> Edit Nama
                    </a>
                    <a href="{{ route('pelanggan.profil.password') }}" class="btn btn-outline-primary flex-fill">
                        <i class="bi bi-key"></i> Ganti Password
                    </a>
                </div>
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