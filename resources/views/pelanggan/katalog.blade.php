@extends('layouts.app')

@section('title', 'Katalog Peralatan')

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
                    <a class="nav-link active" href="{{ route('pelanggan.dashboard') }}">Beranda</a>
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
                    <a class="nav-link" href="{{ route('pelanggan.profil') }}">Profil</a>
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
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Katalog Peralatan</h1>
        <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->full_name }}</strong>!</p>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari alat..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $kat)
                        <option value="{{ $kat->category_id }}" {{ request('kategori') == $kat->category_id ? 'selected' : '' }}>
                            {{ $kat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Disewa</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    <!-- Catalog Grid -->
    <div class="row g-4">
        @forelse($equipments as $alat)
            <div class="col-lg-4 col-md-6">
                <div class="card catalog-card h-100">
                    <div class="catalog-img-wrapper position-relative">
                        @if($alat->image_url)
                            <img src="{{ asset('uploads/equipments/' . $alat->image_url) }}" class="catalog-img" alt="{{ $alat->name }}">
                        @else
                            <div class="catalog-img bg-secondary d-flex align-items-center justify-content-center text-white">No Image</div>
                        @endif
                        <span class="status-badge status-{{ $alat->status }}">
                            {{ $alat->status == 'available' ? 'Tersedia' : 'Disewa' }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-primary mb-2 align-self-start" style="font-size: 0.7rem;">
                            {{ $alat->category->category_name ?? 'Umum' }}
                        </span>
                        <h5 class="card-title">{{ $alat->name }}</h5>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($alat->description, 80) }}</p>
                        <div class="catalog-price mb-2">
                            Rp {{ number_format($alat->price_per_day, 0, ',', '.') }} <small class="text-muted fw-normal">/hari</small>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-box-seam"></i> Stok: <strong class="text-success">{{ $alat->stock }}</strong>
                            </small>
                        </div>
                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('pelanggan.detail', $alat->equipment_id) }}" class="btn btn-outline-primary flex-fill">Detail</a>
                            @if($alat->status == 'available' && $alat->stock > 0)
                                <a href="{{ route('pelanggan.detail', $alat->equipment_id) }}" class="btn btn-primary flex-fill">Sewa</a>
                            @else
                                <button class="btn btn-secondary flex-fill" disabled>Tidak Tersedia</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ABABAB;"></i>
                <p class="text-muted mt-3">Tidak ada peralatan yang ditemukan.</p>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-primary">Reset Filter</a>
            </div>
        @endforelse
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Gear Rental. All rights reserved.</p>
    </div>
</footer>
@endsection