@extends('layouts.app')

@section('title', 'Manajemen User')

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
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.peralatan.index') }}">Peralatan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.user.index') }}">User</a></li>
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
    <h1 class="fw-bold mb-4">Manajemen User</h1>

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
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th width="100">Role</th>
                            <th>Tanggal Daftar</th>
                            <th width="100">Transaksi</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $no => $u)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td><strong>{{ $u->username }}</strong></td>
                                <td>{{ $u->full_name }}</td>
                                <td><span class="badge bg-primary">{{ ucfirst($u->role) }}</span></td>
                                <td>{{ $u->created_at->format('d/m/Y') }}</td>
                                <td><span class="badge bg-dark">{{ $u->rentals_count }}</span></td>
                                <td>
                                    @if($u->user_id != Auth::id())
                                        <a href="{{ route('admin.user.destroy', $u->user_id) }}" class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Hapus user ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    @else
                                        <span class="text-muted small">Akun sendiri</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada user</td></tr>
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