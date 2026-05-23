<?php

use App\Http\Controllers\ItemController;
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
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    // Nanti tambah Route::post untuk simpan data di sini

    // Halaman Kasir (Pembayaran)
       Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
       
    // data transaksi   
       Route::get('/transaksi', [TransaksiController::class, 'index'])->name('data_transaksi.index');
   
       // data item 
         
       Route::get('/item', [ItemController::class, 'index'])->name('item.index');
       Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
       Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');
       Route::post('/item/destroy/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
       Route::put('/item/{item}', [ItemController::class, 'update'])->name('item.update');

   
});


require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
