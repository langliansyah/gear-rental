@extends('layouts.app')

@section('title', 'Tambah Peralatan')

@section('content')
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
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.kategori.index') }}">Kategori</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.peralatan.index') }}">Peralatan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.user.index') }}">User</a></li>
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

<div class="container py-5">
    <a href="{{ route('admin.peralatan.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="auth-form" style="max-width: 100%;">
                <h1>Tambah Peralatan</h1>
                <p class="subtitle">Tambahkan peralatan pendakian baru.</p>

                @if($errors->any())
                    <div class="alert alert-error">
                        @foreach($errors->all() as $err)
                            <p class="mb-0">{{ $err }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.peralatan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Alat</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Kategori</label>
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $kat)
                                <option value="{{ $kat->category_id }}" {{ old('category_id') == $kat->category_id ? 'selected' : '' }}>
                                    {{ $kat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="price_per_day" class="form-label fw-semibold">Harga/Hari (Rp)</label>
                            <input type="number" id="price_per_day" name="price_per_day" class="form-control" 
                                   value="{{ old('price_per_day') }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-semibold">Stok</label>
                            <input type="number" id="stock" name="stock" class="form-control" 
                                   value="{{ old('stock', 1) }}" min="1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">Gambar</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Format: jpg, jpeg, png, gif. Max 2MB</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Gear Rental. All rights reserved.</p>
    </div>
</footer>
@endsection