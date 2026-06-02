<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

/*
|--------------------------------------------------------------------------
| Web Routes - Smart Library Management System (SLS)
|--------------------------------------------------------------------------
*/

// ======================================================================
// 1. RUTE PUBLIK (Bisa Diakses Siapa Saja Tanpa Login)
// ======================================================================
Route::get('/', function () { 
    return view('welcome'); 
})->name('welcome');

Route::get('/login', function () { 
    return view('login'); 
})->name('login');

Route::post('/login', [LibraryController::class, 'prosesLogin'])->name('login.proses');


// ======================================================================
// 2. RUTE GERBANG ELEKTRONIK ADMIN / AUTOMATION (Bebas dari Proteksi Session User)
// ======================================================================
// Rute otomatisasi eksternal untuk mengubah status via n8n webhook
Route::post('/api/n8n/update-status/{id}', [LibraryController::class, 'updateStatusViaN8N'])
    ->name('api.n8n.update');

// Rute otomatisasi eksternal untuk dipanggil n8n setiap pagi (Menyaring H-1 Tenggat)
Route::get('/api/n8n/check-due-dates', [LibraryController::class, 'cekTenggatPeminjaman'])
    ->name('api.n8n.check-due');

// Rute konfirmasi pengembalian fisik buku oleh Admin
Route::post('/api/admin/konfirmasi-kembali/{id}', [LibraryController::class, 'konfirmasiPengembalianFisik'])
    ->name('admin.konfirmasi.kembali');


// ======================================================================
// 3. RUTE PROTEKSI MULTI-ROLE (Wajib Login Dahulu)
// ======================================================================
Route::middleware(['auth'])->group(function () {

    // --- 🎒 JALUR AKSES MAHASISWA & UMUM ---
    Route::get('/dashboard', [LibraryController::class, 'dashboard'])->name('dashboard');
    Route::get('/katalog', [LibraryController::class, 'katalog'])->name('katalog');
    Route::get('/peminjaman', [LibraryController::class, 'peminjaman'])->name('peminjaman');

    // Transaksi Sirkulasi Buku Sisi Mahasiswa
    Route::post('/pinjam-buku/{id}', [LibraryController::class, 'pinjamBuku'])->name('buku.pinjam');
    Route::post('/kembalikan-buku/{id}', [LibraryController::class, 'kembalikanBuku'])->name('buku.kembalikan');

    // --- 👑 BUNDEL RUTE KHUSUS PETUGAS / ADMIN ---
    Route::get('/admin/dashboard', [LibraryController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/verifikasi', [LibraryController::class, 'verifikasiSirkulasi'])->name('admin.verifikasi');
    Route::post('/admin/setujui-pinjam/{id}', [LibraryController::class, 'setujuiPeminjaman'])->name('admin.setujui.pinjam');
    Route::post('/admin/konfirmasi-kembali/{id}', [LibraryController::class, 'konfirmasiPengembalianFisik'])->name('admin.konfirmasi.kembali');
    
    // Manajemen Master Data Katalog Buku Sisi Admin
    Route::get('/admin/katalog', [LibraryController::class, 'katalogAdmin'])->name('admin.katalog');
    Route::post('/admin/katalog/update-stok/{id}', [LibraryController::class, 'updateStokBuku'])->name('admin.katalog.update-stok');

    // Manajemen Data Anggota Aktif (Dinamis dari Database)
    Route::get('/admin/anggota', [LibraryController::class, 'anggotaAdmin'])->name('anggota');
    
    // Mengarah ke method dinamis resmi di LibraryController
    Route::get('/admin/laporan', [LibraryController::class, 'laporanAdmin'])->name('laporan');

    // Proses Keluar dari Aplikasi
    Route::post('/logout', [LibraryController::class, 'prosesLogout'])->name('logout');
});