<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
      public function index()
    {
        // $bookings = Booking::latest()->get(); // Ambil data terbaru
        // return view('booking.index', compact('bookings'));
        return view('data_transaksi.index');
    }
    
}
