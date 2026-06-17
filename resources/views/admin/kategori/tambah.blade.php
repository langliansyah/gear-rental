@extends('layouts.app')

@section('title', 'Tambah Kategori')

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
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.kategori.index') }}">Kategori</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.peralatan.index') }}">Peralatan</a></li>
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
    <a href="{{ route('admin.kategori.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="auth-form">
                <h1>Tambah Kategori</h1>
                <p class="subtitle">Tambahkan kategori peralatan baru.</p>

                @if($errors->any())
                    <div class="alert alert-error">
                        @foreach($errors->all() as $err)
                            <p class="mb-0">{{ $err }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.kategori.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" id="category_name" name="category_name" class="form-control" 
                               value="{{ old('category_name') }}" placeholder="Contoh: Tenda" required>
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