@extends('layouts.app')

@section('title', 'Manajemen Peralatan')

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Manajemen Peralatan</h1>
        <a href="{{ route('admin.peralatan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Peralatan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: var(--bs-border-radius);">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="80">Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga/Hari</th>
                            <th width="70">Stok</th>
                            <th width="120">Status</th>
                            <th width="280">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipments as $no => $alat)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    @if($alat->image_url)
                                        <img src="{{ asset('uploads/equipments/' . $alat->image_url) }}" 
                                             class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="bi bi-image text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $alat->name }}</strong></td>
                                <td>{{ $alat->category->category_name ?? '-' }}</td>
                                <td>Rp {{ number_format($alat->price_per_day, 0, ',', '.') }}</td>
                                <td><span class="badge bg-dark">{{ $alat->stock }}</span></td>
                                <td>
                                    @if($alat->status == 'available')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($alat->status == 'rented')
                                        <span class="badge bg-warning text-dark">Disewa</span>
                                    @else
                                        <span class="badge bg-danger">Maintenance</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.peralatan.edit', $alat->equipment_id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.peralatan.status', $alat->equipment_id) }}" class="btn btn-outline-info">
                                            <i class="bi bi-arrow-repeat"></i> Status
                                        </a>
                                        <a href="{{ route('admin.peralatan.destroy', $alat->equipment_id) }}" class="btn btn-outline-danger"
                                           onclick="return confirm('Yakin hapus?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada peralatan</td></tr>
                        @endforelse
                    </tbody>
                </table>
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