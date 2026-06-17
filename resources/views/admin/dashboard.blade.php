@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Navbar Admin -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Gear Rental - Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.kategori.index') }}">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.peralatan.index') }}">Peralatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.peminjaman.index') }}">Peminjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.user.index') }}">User</a>
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
        <h1 class="display-5 fw-bold mb-2">Dashboard Admin</h1>
        <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->full_name }}</strong>!</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="border-left: 5px solid #1D9E75;">
            <div class="stat-icon">✓</div>
            <div class="stat-info">
                <h3>{{ $available }}</h3>
                <p>Alat Tersedia</p>
            </div>
        </div>
        <div class="stat-card" style="border-left: 5px solid #FFB61D;">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3>{{ $rented }}</h3>
                <p>Alat Disewa</p>
            </div>
        </div>
        <div class="stat-card" style="border-left: 5px solid #DC3545;">
            <div class="stat-icon">🔧</div>
            <div class="stat-info">
                <h3>{{ $maintenance }}</h3>
                <p>Alat Maintenance</p>
            </div>
        </div>
        <div class="stat-card" style="border-left: 5px solid #8B5CF6;">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <h3>{{ $pending }}</h3>
                <p>Transaksi Pending</p>
            </div>
        </div>
        <div class="stat-card" style="border-left: 5px solid #3B82F6;">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <h3>{{ $paid }}</h3>
                <p>Transaksi Paid</p>
            </div>
        </div>
        <div class="stat-card" style="border-left: 5px solid #E9663C;">
            <div class="stat-icon">👤</div>
            <div class="stat-info">
                <h3>{{ $total_user }}</h3>
                <p>User Terdaftar</p>
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