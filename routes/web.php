<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logoutGet'])->name('logout');

 Route::middleware(['auth'])->group(function () {
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartDataAjax'])->name('dashboard.chart-data');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/barang/data', [BarangController::class, 'getBarang'])->name('barang.data');
    Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
    Route::post('/barang/restock', [BarangController::class, 'restock'])->name('barang.restock');
    Route::get('/stok-rendah', [BarangController::class, 'getStokRendah'])->name('barang.stokrendah');
    Route::get('/barang/next-kode', [BarangController::class, 'getNextKode'])->name('barang.nextkode');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori/{id}', [KategoriController::class, 'show'])->whereNumber('id')->name('kategori.show');
    Route::get('/kategori/next-kode', [KategoriController::class, 'getNextKode'])->name('kategori.nextkode');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}/print', [TransaksiController::class, 'print'])->name('transaksi.print');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/data', [TransaksiController::class, 'getTransaksi'])->name('transaksi.data');
    Route::get('/produk-terlaris', [DashboardController::class, 'produkTerlaris'])->name('produk.terlaris');
    Route::delete('/transaksi/hapus-semua', [TransaksiController::class, 'destroyAll'])->name('transaksi.destroyAll');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('/laporan/stok', [LaporanController::class, 'laporanStok'])->name('laporan.stok');
    Route::get('/laporan/grafik', [LaporanController::class, 'grafikPenjualan'])->name('laporan.grafik');

    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');
    Route::post('/akun/profil', [AkunController::class, 'updateProfile'])->name('akun.profil');
});
