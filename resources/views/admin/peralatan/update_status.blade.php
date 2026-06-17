@extends('layouts.app')

@section('title', 'Update Status')

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
        <div class="col-lg-5">
            <div class="auth-form">
                <h1>Update Status</h1>
                <p class="subtitle">Ubah status peralatan.</p>

                <div class="alert alert-light border mb-4">
                    <strong>Nama Alat:</strong> {{ $equipment->name }}<br>
                    <strong>Status Saat Ini:</strong> 
                    @if($equipment->status == 'available')
                        <span class="badge bg-success">Tersedia</span>
                    @elseif($equipment->status == 'rented')
                        <span class="badge bg-warning text-dark">Disewa</span>
                    @else
                        <span class="badge bg-danger">Maintenance</span>
                    @endif
                </div>

                <form method="POST" action="{{ route('admin.peralatan.status.update', $equipment->equipment_id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Baru</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="available" {{ $equipment->status == 'available' ? 'selected' : '' }}>Available (Tersedia)</option>
                            <option value="maintenance" {{ $equipment->status == 'maintenance' ? 'selected' : '' }}>Maintenance (Perbaikan)</option>
                            <option value="rented" {{ $equipment->status == 'rented' ? 'selected' : '' }}>Rented (Disewa)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat"></i> Update Status
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