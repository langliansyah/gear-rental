@extends('layouts.app')

@section('title', 'Detail ' . $equipment->name)

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
    <a href="{{ route('pelanggan.dashboard') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Katalog
    </a>

    <div class="row g-5">
        <!-- Gambar -->
        <div class="col-lg-6">
            @if($equipment->image_url)
                <img src="{{ asset('uploads/equipments/' . $equipment->image_url) }}" 
                     class="w-100 rounded-4 shadow-sm" style="max-height: 450px; object-fit: cover;" 
                     alt="{{ $equipment->name }}">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center text-white rounded-4" 
                     style="height: 400px;">No Image</div>
            @endif
        </div>

        <!-- Info -->
        <div class="col-lg-6">
            <span class="badge status-{{ $equipment->status }} mb-2" style="font-size: 0.8rem; padding: 8px 16px;">
                {{ $equipment->status == 'available' ? 'Tersedia' : ($equipment->status == 'rented' ? 'Disewa' : 'Maintenance') }}
            </span>
            
            <h1 class="fw-bold mb-2">{{ $equipment->name }}</h1>
            <p class="text-muted mb-3">
                <i class="bi bi-folder"></i> Kategori: {{ $equipment->category->category_name ?? 'Tanpa Kategori' }}
            </p>
            
            <div class="detail-price mb-3">
                Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }} <span>/hari</span>
            </div>
            
            <div class="mb-3 fs-5">
                <i class="bi bi-box-seam"></i> Stok: <strong class="text-success">{{ $equipment->stock }}</strong>
            </div>

            <div class="detail-description">
                <h5 class="fw-bold mb-2">Deskripsi</h5>
                <p>{!! nl2br(e($equipment->description)) !!}</p>
            </div>

            @if($equipment->status == 'available' && $equipment->stock > 0)
                <div class="sewa-form mt-4">
                    <h4 class="fw-bold mb-3">Form Peminjaman</h4>
                    
                    @if(session('error'))
                        <div class="alert alert-error">{{ session('error') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('pelanggan.keranjang.store', $equipment->equipment_id) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" 
                                   value="1" min="1" max="{{ $equipment->stock }}" required>
                            <small class="text-muted">Maksimal: {{ $equipment->stock }}</small>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="tgl_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" id="tgl_mulai" name="tgl_mulai" class="form-control"
                                       min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tgl_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                                <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                        </div>

                        <!-- Metode Pengambilan -->
                        <div class="mb-3">
                            <label for="metode" class="form-label fw-semibold">Metode Pengambilan</label>
                            <select id="metode" name="metode" class="form-control" required onchange="toggleAlamat()">
                                <option value="toko">Ambil ke Toko</option>
                                <option value="cod">COD (Kirim ke Alamat)</option>
                            </select>
                        </div>

                        <!-- Pilih Toko -->
                        <div class="mb-3" id="pilih-toko">
                            <label for="toko" class="form-label fw-semibold">Pilih Toko Terdekat</label>
                            <select id="toko" name="toko" class="form-control">
                                <option value="">-- Pilih Toko --</option>
                                <option value="Toko Pusat - Jl. Sudirman No.1, Jakarta">Toko Pusat - Jl. Sudirman No.1, Jakarta</option>
                                <option value="Toko Cabang - Jl. Merdeka No.5, Bandung">Toko Cabang - Jl. Merdeka No.5, Bandung</option>
                                <option value="Toko Gunung - Jl. Raya Puncak No.10, Bogor">Toko Gunung - Jl. Raya Puncak No.10, Bogor</option>
                            </select>
                        </div>

                        <!-- Alamat COD -->
                        <div class="mb-3" id="form-alamat" style="display: none;">
                            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" class="form-control" rows="3" 
                                      placeholder="Jl. Mawar No.12, RT 03 RW 05, Kelurahan X, Kecamatan Y, Kota Z, 12345"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            @else
                <div class="alert alert-warning mt-4">
                    <i class="bi bi-exclamation-triangle"></i> Maaf, alat ini sedang tidak tersedia untuk disewa.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Gear Rental. All rights reserved.</p>
    </div>
</footer>

<!-- Script Toggle -->
<script>
function toggleAlamat() {
    const metode = document.getElementById('metode').value;
    document.getElementById('pilih-toko').style.display = metode === 'toko' ? 'block' : 'none';
    document.getElementById('form-alamat').style.display = metode === 'cod' ? 'block' : 'none';
}
</script>
@endsection