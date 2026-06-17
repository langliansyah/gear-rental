@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

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
                    <a class="nav-link active" href="{{ route('pelanggan.riwayat') }}">Riwayat</a>
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
    <div class="mb-5">
        <h1 class="display-5 fw-bold mb-2">Riwayat Peminjaman</h1>
        <p class="text-muted">Lihat semua transaksi peminjaman alat pendakianmu.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($rentals->count() > 0)
        <div class="row g-4">
            @foreach($rentals as $rental)
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: var(--bs-border-radius);">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <span class="badge bg-dark text-uppercase" style="font-size: 0.7rem;">
                                        #{{ str_pad($rental->rental_id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <small class="text-muted d-block">Tanggal</small>
                                    <strong>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d M Y') }}</strong>
                                    <br>
                                    <small class="text-muted">s/d {{ \Carbon\Carbon::parse($rental->return_date_expected)->format('d M Y') }}</small>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <small class="text-muted d-block">Peralatan</small>
                                    @foreach($rental->rentalItems as $item)
                                        <span class="badge bg-light text-dark mb-1">
                                            {{ $item->equipment->name ?? '-' }} ({{ $item->quantity }}x)
                                        </span>
                                        <br>
                                    @endforeach
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <small class="text-muted d-block">Metode</small>
                                    @if($rental->metode_pengambilan == 'cod')
                                        <span class="badge bg-info">
                                            <i class="bi bi-truck"></i> COD
                                        </span>
                                        <br><small class="text-muted">{{ $rental->alamat ?? '-' }}</small>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-shop"></i> Ambil ke Toko
                                        </span>
                                        <br><small class="text-muted">{{ $rental->toko_tujuan ?? '-' }}</small>
                                    @endif
                                </div>
                                <div class="col-md-2 text-md-end">
                                    <strong class="text-primary d-block">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
                                    @if($rental->status_payment == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($rental->status_payment == 'paid')
                                        <span class="badge bg-success">Dibayar</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-clock-history" style="font-size: 5rem; color: #ABABAB;"></i>
            <h3 class="mt-3 text-muted">Belum ada riwayat peminjaman</h3>
            <p class="text-muted">Mulai sewa perlengkapan pendakian sekarang!</p>
            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-box"></i> Lihat Katalog
            </a>
        </div>
    @endif
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Gear Rental. All rights reserved.</p>
    </div>
</footer>
@endsection