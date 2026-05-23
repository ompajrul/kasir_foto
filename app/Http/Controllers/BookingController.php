<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Item;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Mengambil data order beserta relasi staf (PIC) dan detail itemnya
        $bookings = Orders::with(['staf', 'details.item'])->latest()->get();

        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $items = Item::all(); // Untuk pilihan dropdown paket
        return view('booking.create', compact('items', 'users'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'instagram' => 'nullable',
            'kostum' => 'nullable',

            'tanggal_booking' => 'required|date',
            'jam' => 'required',
            'id_item' => 'required|exists:items,id', // id_item datang dari dropdown
            'pic' => 'required', // Pastikan ini ID user
        ]);
        // dd($request->all());
        // 2. Simpan ke tabel Order
        $order = Orders::create([
            'instagram' => $request->instagram,
            'jam' => $request->jam,
            'kostum' => $request->kostum,
            'status_order' => $request->status_order ?? 'pending',
            'pic' => auth()->id(), // Mengambil ID user yang login sebagai PIC
            'tanggal_booking' => $request->tanggal_booking,
            'note' => $request->note,
        ]);

        // 3. Ambil data harga dari tabel Item untuk disimpan ke Detail
        $item = Item::find($request->id_item);

        // 4. Simpan ke tabel Detail (Sesuai Screenshot 2026-05-05 151454.png)
        \App\Models\Details::create([
            'id_order' => $order->id,
            'id_item' => $item->id,
            'harga_satuan' => $item->harga, // Mengunci harga saat booking
        ]);

        return redirect()->route('booking.index')->with('success', 'Order Berhasil!');
    }
}