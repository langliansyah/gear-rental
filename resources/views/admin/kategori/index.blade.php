@extends('layouts.app')

@section('title', 'Manajemen Kategori')

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">Manajemen Kategori</h1>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
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
                            <th width="80">No</th>
                            <th>Nama Kategori</th>
                            <th width="150">Jumlah Alat</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $no => $kat)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td><strong>{{ $kat->category_name }}</strong></td>
                                <td><span class="badge bg-primary">{{ $kat->equipments_count }}</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.kategori.edit', $kat->category_id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.kategori.destroy', $kat->category_id) }}" class="btn btn-outline-danger"
                                           onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada kategori</td></tr>
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