<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;

Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::prefix('master-data')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('warehouses', WarehouseController::class);
    });

    // Transactions
    Route::get('/barang-masuk', [GoodsReceiptController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/create', [GoodsReceiptController::class, 'create'])->name('barang-masuk.create');
    Route::post('/barang-masuk', [GoodsReceiptController::class, 'store'])->name('barang-masuk.store');

    Route::get('/barang-keluar', [DeliveryOrderController::class, 'index'])->name('barang-keluar.index');
    Route::get('/barang-keluar/create', [DeliveryOrderController::class, 'create'])->name('barang-keluar.create');
    Route::post('/barang-keluar', [DeliveryOrderController::class, 'store'])->name('barang-keluar.store');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/export', [ReportController::class, 'exportExcel'])->name('reports.export');

    // Settings
    Route::get('/settings/company', [SettingsController::class, 'company'])->name('settings.company');
    Route::post('/settings/company', [SettingsController::class, 'updateCompany'])->name('settings.company.update');
});

require __DIR__.'/auth.php';
