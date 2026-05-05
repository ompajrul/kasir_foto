<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Halaman Booking (Pencatatan Coser)
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    // Nanti tambah Route::post untuk simpan data di sini

    // Halaman Kasir (Pembayaran)
       Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
       
    // data transaksi   
       Route::get('/transaksi', [TransaksiController::class, 'index'])->name('data_transaksi.index');

   
});


require __DIR__.'/auth.php';
