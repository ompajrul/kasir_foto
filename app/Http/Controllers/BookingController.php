<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Item;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    // Suntikkan Service Layer ke dalam constructor Controller
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = Orders::with(['staf', 'details.item'])->latest()->get();
        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $items = Item::all(); 
        return view('booking.create', compact('items', 'users'));
    }

    public function store(StoreBookingRequest $request)
    {
        // Ambil data yang sudah lolos validasi dari Form Request, lalu lempar ke Service
        $this->bookingService->createBooking($request->validated());

        return redirect()->route('booking.index')->with('success', 'Order Berhasil!');
    }

    public function edit($id)
    {
        $booking = Orders::with('details')->findOrFail($id);
        $items = Item::all();
        $users = \App\Models\User::all();

        $current_item_id = $booking->details()->whereHas('item', fn($q) => $q->where('jenis', 'paket'))->first()->id_item ?? null;
        $current_addons = $booking->details()->whereHas('item', fn($q) => $q->where('jenis', 'add_on'))->pluck('id_item')->toArray();

        return view('booking.edit', compact('booking', 'items', 'users', 'current_item_id', 'current_addons'));
    }

    public function update(UpdateBookingRequest $request, $id)
    {
        // Jalankan proses update lewat Service
        $this->bookingService->updateBooking($id, $request->validated());

        return redirect()->route('booking.index')->with('success', 'Data booking berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $booking = Orders::findOrFail($id);
        \App\Models\Details::where('id_order', $booking->id)->delete();
        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Data booking berhasil dihapus!');
    }
}