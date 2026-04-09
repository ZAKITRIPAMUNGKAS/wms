<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');

Route::get('/barang-masuk', [TransactionController::class, 'inbound'])->name('barang-masuk.index');
Route::get('/barang-keluar', [TransactionController::class, 'outbound'])->name('barang-keluar.index');
Route::get('/transaksi/{id}', [TransactionController::class, 'show'])->name('transaction.show');

Route::get('/inventori', function() {
    return view('inventory.index');
})->name('inventory.index');

Route::get('/laporan', function() {
    return view('reports.index');
})->name('reports.index');
