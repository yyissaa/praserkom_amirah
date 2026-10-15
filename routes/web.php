<?php

use App\Http\Controllers\ProfileController; // ambil ProfileController (bawaan breeze)
use Illuminate\Support\Facades\Route; // ambil class route
use App\Http\Controllers\EventController; // ambil EventController
use App\Http\Controllers\OrderController; //ambil OrderController

// 1. Halaman utama (Katalog Daftar Event Pembeli)
// kalau buka "/", jalankan fungsi index dan tampilkan daftar event pembeli //nama route: customer.index
Route::get('/', [OrderController::class, 'index'])->name('customer.index');
// kalau kirim form ke "/checkout", jalankan fungsi store dan simpan pembelian //nama route: "customer.checkout"
Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');

// 2. Arahkan dashboard utama Breeze langsung ke Admin Dashboard Rekap Pesanan
Route::get('/dashboard', [OrderController::class, 'adminDashboard']) 
    ->middleware(['auth', 'verified']) // halaman dashboard admin, wajib login dan email terverifikasi
    ->name('dashboard');

// 3. Grup Rute Admin (Wajib Login)
Route::middleware('auth')->group(function () { // grup route yg waib login
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); //halaman edit profile
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // halaman perubahan profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // halaman hapus akun

    // route untuk admin dashboard & update status pesanan
    Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard'); //halaman dashboard admin
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus'); //ubah status pesanan

    //untuk CRUD event
    Route::resource('/admin/events', EventController::class);
    // otomatis bikin 7 route CRUD makanan (index, create, store, show, edit, update, destroy)
});

require __DIR__.'/auth.php'; // panggil route login/register bawaan breeze
