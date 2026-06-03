<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Item;
use App\Models\Transaksi;


class HomeController extends Controller
{
    
    public function index()
    {
        // 1. Hitung total antrean booking yang masih pending
        $totalPendingBooking = Orders::where('status_order', 'pending')->count();

        // 2. Hitung jumlah total transaksi yang sukses lunas hari ini
        $totalTransaksiSukses = Transaksi::count();

        // 3. Hitung omset total kasir saat ini
        $omsetTotal = Transaksi::sum('total_biaya');

        // 4. Hitung berapa variasi item/paket layanan yang dimiliki studio
        $totalProduk = Item::count();

       return view('dashboard', compact('totalPendingBooking', 'totalTransaksiSukses', 'omsetTotal', 'totalProduk'));

    }
}
