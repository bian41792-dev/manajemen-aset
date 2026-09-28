<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetMutationController;
use App\Http\Controllers\AssetLoanController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Halaman awal: arahkan ke dashboard jika sudah login, ke login jika belum
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master data
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('locations', LocationController::class)->except('show');
    Route::resource('assets', AssetController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');

    // Mutasi
    Route::resource('mutations', AssetMutationController::class)->except('show');

    // Peminjaman
    Route::resource('loans', AssetLoanController::class)->except('show');
    Route::patch('loans/{loan}/return', [AssetLoanController::class, 'returnLoan'])->name('loans.return');

    // Pemeliharaan
    Route::resource('maintenances', MaintenanceRecordController::class)->except('show');
    Route::patch('maintenances/{maintenance}/complete', [MaintenanceRecordController::class, 'complete'])->name('maintenances.complete');

    // Laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
});

require __DIR__.'/auth.php';