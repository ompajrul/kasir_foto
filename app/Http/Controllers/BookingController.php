<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Item;
use App\Models\Details;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Orders::with(['staf', 'details.item'])->latest()->get();
        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $items = Item::all(); // Mengambil semua item (nanti difilter jenisnya di blade)
        return view('booking.create', compact('items', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'instagram'       => 'nullable',
            'kostum'          => 'nullable',
            'tanggal_booking' => 'required|date',
            'jam'             => 'required',
            'id_item'         => 'required|exists:items,id', // ID dari Radio Button Paket Utama
            'pic'             => 'required',                 // ID Staf penanggung jawab
            'addons'          => 'nullable|array',           // Validasi array checkbox add-on
            'addons.*'        => 'exists:items,id',
        ]);

        // 1. Simpan ke tabel Orders
        $order = Orders::create([
            'instagram'       => $request->instagram,
            'jam'             => $request->jam,
            'kostum'          => $request->kostum,
            'status_order'    => $request->status_order ?? 'pending',
            'pic'             => $request->pic, // Menggunakan input pic dari form agar dinamis
            'tanggal_booking' => $request->tanggal_booking,
            'note'            => $request->note,
        ]);

        // 2. Simpan Paket Utama (Radio Button) ke tabel Details
        $paketUtama = Item::findOrFail($request->id_item);
        Details::create([
            'id_order'     => $order->id,
            'id_item'      => $paketUtama->id,
            'harga_satuan' => $paketUtama->harga, 
        ]);

        // 3. Simpan Semua Add-on yang Dicentang (Checkbox) ke tabel Details
        if ($request->has('addons')) {
            foreach ($request->addons as $addonId) {
                $addonItem = Item::findOrFail($addonId);
                Details::create([
                    'id_order'     => $order->id,
                    'id_item'      => $addonItem->id,
                    'harga_satuan' => $addonItem->harga,
                ]);
            }
        }

        return redirect()->route('booking.index')->with('success', 'Order Berhasil!');
    }

    public function edit($id)
    {
        $booking = Orders::with('details')->findOrFail($id);
        $items = Item::all();
        $users = \App\Models\User::all();

        // Ambil ID paket utama (item berjenis paket) yang saat ini dipilih
        $current_item_id = $booking->details()
            ->whereHas('item', function($query) {
                $query->where('jenis', 'paket');
            })->first()->id_item ?? null;

        // Ambil kumpulan ID add-on yang saat ini nempel pada order ini
        $current_addons = $booking->details()
            ->whereHas('item', function($query) {
                $query->where('jenis', 'add_on');
            })->pluck('id_item')->toArray();

        return view('booking.edit', compact('booking', 'items', 'users', 'current_item_id', 'current_addons'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'instagram'       => 'required',
            'tanggal_booking' => 'required|date',
            'jam'             => 'required',
            'pic'             => 'required',
            'id_item'         => 'required|exists:items,id',
            'status'          => 'required',
            'addons'          => 'nullable|array',
            'addons.*'        => 'exists:items,id',
        ]);

        $booking = Orders::findOrFail($id);

        // 1. Update data dasar order
        $booking->update([
            'instagram'       => $request->instagram,
            'tanggal_booking' => $request->tanggal_booking,
            'jam'             => $request->jam,
            'kostum'          => $request->kostum,
            'status_order'    => $request->status, 
            'pic'             => $request->pic,
            'note'            => $request->note,
        ]);

        // 2. Bersihkan detail lama terlebih dahulu untuk mendata ulang paket & add-on
        Details::where('id_order', $booking->id)->delete();

        // 3. Masukkan kembali Paket Utama yang baru/diubah
        $paketUtama = Item::findOrFail($request->id_item);
        Details::create([
            'id_order'     => $booking->id,
            'id_item'      => $paketUtama->id,
            'harga_satuan' => $paketUtama->harga,
        ]);

        // 4. Masukkan kembali Add-on baru jika ada yang dicentang
        if ($request->has('addons')) {
            foreach ($request->addons as $addonId) {
                $addonItem = Item::findOrFail($addonId);
                Details::create([
                    'id_order'     => $booking->id,
                    'id_item'      => $addonItem->id,
                    'harga_satuan' => $addonItem->harga,
                ]);
            }
        }

        return redirect()->route('booking.index')->with('success', 'Data booking berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $booking = Orders::findOrFail($id);
        Details::where('id_order', $booking->id)->delete();
        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Data booking berhasil dihapus!');
    }
}