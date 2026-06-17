@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

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
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
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
    <h1 class="fw-bold mb-4">Manajemen Peminjaman</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="filter-section mb-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-auto">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: var(--bs-border-radius);">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Peralatan</th>
                            <th>Metode</th>
                            <th>Total</th>
                            <th width="100">Status</th>
                            <th width="250">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $no => $r)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>
                                    <strong>{{ $r->user->full_name }}</strong>
                                    <br><small class="text-muted">{{ $r->user->username }}</small>
                                </td>
                                <td>
                                    <small>{{ \Carbon\Carbon::parse($r->rental_date)->format('d/m/Y') }}</small>
                                    <br><small class="text-muted">s/d {{ \Carbon\Carbon::parse($r->return_date_expected)->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    @foreach($r->rentalItems as $item)
                                        <span class="badge bg-light text-dark mb-1">{{ $item->equipment->name ?? '-' }} ({{ $item->quantity }}x)</span><br>
                                    @endforeach
                                </td>
                                <td>
                                    @if($r->metode_pengambilan == 'cod')
                                        <span class="badge bg-info"><i class="bi bi-truck"></i> COD</span>
                                        <br><small class="text-muted">{{ Str::limit($r->alamat, 30) }}</small>
                                    @else
                                        <span class="badge bg-success"><i class="bi bi-shop"></i> Toko</span>
                                        <br><small class="text-muted">{{ Str::limit($r->toko_tujuan, 30) }}</small>
                                    @endif
                                </td>
                                <td><strong class="text-primary">Rp {{ number_format($r->total_price, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($r->status_payment == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($r->status_payment == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($r->status_payment == 'pending')
                                            <a href="{{ route('admin.peminjaman.konfirmasi', $r->rental_id) }}" class="btn btn-outline-success"
                                               onclick="return confirm('Konfirmasi pembayaran?')">
                                                <i class="bi bi-check-lg"></i> Konfirmasi
                                            </a>
                                            <a href="{{ route('admin.peminjaman.batalkan', $r->rental_id) }}" class="btn btn-outline-danger"
                                               onclick="return confirm('Batalkan peminjaman?')">
                                                <i class="bi bi-x-lg"></i> Batal
                                            </a>
                                        @endif
                                        @if($r->status_payment == 'paid')
                                            <a href="{{ route('admin.peminjaman.struk', $r->rental_id) }}" target="_blank" class="btn btn-outline-info">
                                                <i class="bi bi-printer"></i> Struk
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi</td></tr>
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