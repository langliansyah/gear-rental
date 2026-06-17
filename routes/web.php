<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PeralatanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Pelanggan\EquipmentController;
use App\Http\Controllers\Pelanggan\KeranjangController;
use App\Http\Controllers\Pelanggan\ProfilController;
use App\Http\Controllers\Pelanggan\RiwayatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pelanggan Routes
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/', [EquipmentController::class, 'index'])->name('dashboard');
    Route::get('/detail/{id}', [EquipmentController::class, 'show'])->name('detail');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::get('/keranjang/hapus/{index}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/password', [ProfilController::class, 'showPasswordForm'])->name('profil.password');
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/tambah', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::get('/kategori/hapus/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    
    // Peralatan
    Route::get('/peralatan', [PeralatanController::class, 'index'])->name('peralatan.index');
    Route::get('/peralatan/tambah', [PeralatanController::class, 'create'])->name('peralatan.create');
    Route::post('/peralatan', [PeralatanController::class, 'store'])->name('peralatan.store');
    Route::get('/peralatan/edit/{id}', [PeralatanController::class, 'edit'])->name('peralatan.edit');
    Route::post('/peralatan/update/{id}', [PeralatanController::class, 'update'])->name('peralatan.update');
    Route::get('/peralatan/hapus/{id}', [PeralatanController::class, 'destroy'])->name('peralatan.destroy');
    Route::get('/peralatan/status/{id}', [PeralatanController::class, 'updateStatus'])->name('peralatan.status');
    Route::post('/peralatan/status/{id}', [PeralatanController::class, 'changeStatus'])->name('peralatan.status.update');
    
    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/konfirmasi/{id}', [PeminjamanController::class, 'konfirmasi'])->name('peminjaman.konfirmasi');
    Route::get('/peminjaman/batalkan/{id}', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');
    Route::get('/peminjaman/struk/{id}', [PeminjamanController::class, 'cetakStruk'])->name('peminjaman.struk');
    
    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/hapus/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

// Redirect root
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role == 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('pelanggan.dashboard');
    }
    return redirect()->route('login');
});