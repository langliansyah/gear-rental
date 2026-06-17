@extends('layouts.app')

@section('title', 'Keranjang')

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
                    <a class="nav-link active" href="{{ route('pelanggan.keranjang') }}">
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

<!-- Keranjang Section -->
<section class="py-5" style="background-color: #f8f9fa; min-height: 80vh;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-2" style="color: var(--accent-color);">Etalase Peminjamanmu</h2>
                <p class="text-muted">Periksa kembali alat hiking yang akan kamu sewa sebelum lanjut ke checkout.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(count($keranjang) > 0)
            <div class="row g-5">
                <!-- Bagian Kiri: Daftar Barang -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm" style="border-radius: var(--bs-border-radius);">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="card-title mb-4">Daftar Alat ({{ count($keranjang) }} Item)</h4>

                            @foreach($keranjang as $index => $item)
                                <div class="row align-items-center border-bottom pb-3 mb-3">
                                    <div class="col-3 col-md-2">
                                        @if(isset($item['image_url']) && $item['image_url'])
                                            <img src="{{ asset('uploads/equipments/' . $item['image_url']) }}" 
                                                 alt="{{ $item['name'] }}" class="img-fluid rounded" 
                                                 style="width: 100px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 100px; height: 80px;">
                                                <i class="bi bi-image text-white fs-4"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-9 col-md-4">
                                        <h5 class="mb-1 fw-bold">{{ $item['name'] }}</h5>
                                        <small class="text-muted">
                                            {{ date('d/m/Y', strtotime($item['tgl_mulai'])) }} - {{ date('d/m/Y', strtotime($item['tgl_selesai'])) }}
                                        </small>
                                        <br>
                                        <small class="text-muted">{{ $item['lama_sewa'] }} hari · Rp {{ number_format($item['price_per_day'], 0, ',', '.') }}/hari</small>
                                    </div>
                                    <div class="col-6 col-md-3 mt-3 mt-md-0">
                                        <span class="badge bg-secondary">Qty: {{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="col-6 col-md-3 mt-3 mt-md-0 text-end">
                                        <span class="fw-bold d-block text-primary fs-5">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </span>
                                        <a href="{{ route('pelanggan.keranjang.destroy', $index) }}" 
                                           class="text-danger small text-decoration-none"
                                           onclick="return confirm('Hapus item ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Lanjutkan Sewa
                        </a>
                    </div>
                </div>

                <!-- Bagian Kanan: Ringkasan Checkout -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm" style="border-radius: var(--bs-border-radius); border-top: 5px solid var(--accent-color) !important;">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Ringkasan Checkout</h4>

                            @php $total = 0 @endphp
                            @foreach($keranjang as $item)
                                @php $total += $item['subtotal'] @endphp
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">{{ $item['name'] }} ({{ $item['quantity'] }}x)</span>
                                    <span class="fw-bold small">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <hr class="mb-3">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Item</span>
                                <span class="fw-bold">{{ count($keranjang) }}</span>
                            </div>

                            <hr class="mb-4">

                            <!-- Total -->
                            <div class="d-flex justify-content-between mb-4 align-items-center">
                                <span class="fw-bold h5 mb-0">Total Bayar</span>
                                <span class="fw-bold h4 mb-0" style="color: var(--bs-primary);">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Tombol Checkout -->
                            <form action="{{ route('pelanggan.keranjang.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 py-3" 
                                        onclick="return confirm('Konfirmasi peminjaman?')">
                                    <i class="bi bi-check-circle"></i> Proses Checkout
                                </button>
                            </form>

                            <p class="text-muted small text-center mt-3 mb-0">
                                <i class="bi bi-shield-check"></i> Pastikan data sudah benar sebelum checkout.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x" style="font-size: 5rem; color: #ABABAB;"></i>
                <h3 class="mt-3 text-muted">Keranjang masih kosong</h3>
                <p class="text-muted">Yuk, pilih perlengkapan pendakian dulu!</p>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary btn-lg mt-3">
                    <i class="bi bi-box"></i> Lihat Katalog
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Gear Rental. All rights reserved.</p>
    </div>
</footer>
@endsection