<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Transaksi;
use App\Models\Item;
use App\Models\User;
use App\Http\Requests\ProsesBayarRequest;
use App\Http\Requests\ProsesBayarOtsRequest;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Exception;

class TransaksiController extends Controller
{
    protected $transaksiService;

    // Suntikkan TransaksiService ke dalam constructor
    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    public function index()
    {
        $transaksis = Orders::with(['details.item', 'staf', 'transaksi.eksekutor'])->latest()->get();

        $totalOmset = $transaksis->sum(function ($order) {
            return $order->totalHarga();
        });

        return view('data_transaksi.index', compact('transaksis', 'totalOmset'));
    }

    public function kasirForm()
    {
        $orders = Orders::with('details.item')->where('status_order', 'pending')->latest()->get();
        $items = Item::all();
        $users = User::all();

        return view('kasir.index', compact('orders', 'items', 'users'));
    }

    public function prosesBayar(ProsesBayarRequest $request)
    {
        try {
            // Serahkan eksekusi ke service layer
            $hasil = $this->transaksiService->bayarBooking($request->validated());

            return redirect()->route('data_transaksi.index')
                ->with('success', "Transaksi Berhasil! Invoice: {$hasil['invoice']}. Kembalian: Rp " . number_format($hasil['kembalian'], 0, ',', '.'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['terbayarkan' => $e->getMessage()]);
        }
    }

    public function prosesBayarOts(ProsesBayarOtsRequest $request)
    {
        try {
            // Serahkan eksekusi ke service layer
            $hasil = $this->transaksiService->bayarOts($request->validated());

            return redirect()->route('data_transaksi.index')
                ->with('success', "Transaksi OTS Sukses atas nama {$hasil['instagram']}! Kembalian: Rp " . number_format($hasil['kembalian'], 0, ',', '.'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['terbayarkan' => $e->getMessage()]);
        }
    }

    public function dashboardIndex()
    {
        $totalPendingBooking = Orders::where('status_order', 'pending')->count();
        $totalTransaksiSukses = Transaksi::count();
        $omsetTotal = Transaksi::sum('total_biaya');
        $totalProduk = Item::count();

        return view('dashboard', compact('totalPendingBooking', 'totalTransaksiSukses', 'omsetTotal', 'totalProduk'));
    }

    public function updateStatusPelaksanaan(Request $request, $id)
    {
        $request->validate([
            'status_pelaksanaan' => 'required|in:waiting,processing,completed'
        ]);

        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Update status operasionalnya
        $transaksi->update([
            'status_pelaksanaan' => $request->status_pelaksanaan
        ]);

        return redirect()->back()->with('success', 'Status pelaksanaan sesi foto berhasil diperbarui!');
    }
}